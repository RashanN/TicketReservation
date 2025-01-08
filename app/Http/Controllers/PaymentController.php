<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Process Payment and Initiate Paycenter Payment
    public function processPayment(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();

        // Step 1: Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string',
            'card_number' => 'required|string',
            'expiry' => 'required|string|date_format:m/y',
            'cvv' => 'required|numeric|digits_between:3,4',
            'total' => 'required|numeric',
        ]);

        // Step 2: Retrieve reservation data from session
        $reservation = $request->session()->get('reservation');

        if (!$reservation) {
            return redirect()->route('welcome')->with('error', 'Reservation data not found.');
        }

        // Step 3: Prepare Payment Init Request
        $amount = $request->input('total');
        $data = [
            'clientId' => env('PAYCENTER_CLIENT_ID'),
            'type' => 'PURCHASE',
            'amount' => [
                'paymentAmount' => $amount * 100, // Convert to cents
                'currency' => 'LKR',
            ],
            'redirect' => [
                'returnUrl' => route('payment.complete'),
                'returnMethod' => 'POST',
            ],
        ];

        // Step 4: Send Payment Init Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYCENTER_AUTH_TOKEN'),
            'Hmac' => hash_hmac('sha256', json_encode($data), env('PAYCENTER_HMAC_SECRET')),
        ])->post(env('PAYCENTER_ENDPOINT') . '/init', $data);

        $responseData = $response->json();

        // Step 5: Redirect to Payment Page
        if (isset($responseData['paymentPageUrl'])) {
            // Store reservation data in session to use after payment
            $request->session()->put('reservation', $reservation);
            return redirect($responseData['paymentPageUrl']);
        }

        return back()->withErrors('Failed to initiate payment.');
    }

    // Complete Payment and Save Member & Ticket Details
    public function complete(Request $request)
    {
        $reqId = $request->input('reqid');

        // Step 1: Send Payment Complete Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYCENTER_AUTH_TOKEN'),
            'Hmac' => hash_hmac('sha256', json_encode(['reqid' => $reqId]), env('PAYCENTER_HMAC_SECRET')),
        ])->post(env('PAYCENTER_ENDPOINT') . '/complete', ['reqid' => $reqId]);

        $responseData = $response->json();

        // Step 2: Check Payment Status
        if ($responseData['responseCode'] === '00') {
            // Step 3: Retrieve reservation data from session
            $reservation = session()->get('reservation');

            if (!$reservation) {
                return redirect()->route('welcome')->with('error', 'Reservation data not found.');
            }

            // Step 4: Save Member Details
            $member = new Member();
            $member->name = $reservation['name'];
            $member->email = $reservation['email'];
            $member->phone = $reservation['phone'];
            $member->nic = $reservation['nic'];
            $member->company_name = $reservation['company'] ?? null;
            $member->designation = $reservation['designation'] ?? null;
            $member->slimID = null;
            $member->other = null;
            $member->save();

            // Step 5: Save Ticket Details
            $ticket = new Ticket();
            $ticket->member_id = $member->id;
            $ticket->Numberof_ticket = $reservation['tickets'];
            $ticket->AgentID = null;
            $ticket->TotalPrice = $reservation['grandTotal'];
            $ticket->DiscountPrice = $reservation['discount'];
            $ticket->Date = Carbon::now()->toDateString();
            $ticket->PaymentStatus = '1'; // Mark payment as complete
            $ticket->IssuedStatus = '1';
            $ticket->IncentivePrice = null;
            $ticket->PaymentType = 'card';
            $ticket->other = null;
            $ticket->save();

            // Step 6: Redirect to Success Page
            return redirect()->route('payment.success')->with('transaction', $responseData);
        }

        // Step 7: Redirect to Failure Page
        return redirect()->route('payment.failure')->with('error', $responseData['responseText']);
    }
}
