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
    // HNB Gateway Configuration
    private $merchantId;
    private $apiKey;
    private $gatewayUrl;

    public function __construct()
    {
        // Load these from .env for security
        $this->merchantId = config('services.hnb.merchant_id');
        $this->apiKey = config('services.hnb.api_key');
        $this->gatewayUrl = config('services.hnb.gateway_url');
    }

    public function processPayment(Request $request)
    {
      
        $currentDate = Carbon::now()->toDateString();
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string',
            'card_number' => 'required|string',
            'expiry' => 'required|string|date_format:m/y',
            'cvv' => 'required|numeric|digits_between:3,4'
        ]);
       
        // Retrieve reservation data from session
        $reservation = $request->session()->get('reservation');
        
        if (!$reservation) {
            return redirect()->route('welcome')->with('error', 'Reservation data not found.');
        }
        $member = new Member();
        $member->name = $reservation['name'];
        $member->email = $reservation['email'];
        $member->phone = $reservation['phone'];
        $member->nic = $reservation['nic'];
        $member->company_name = $reservation['company'] ?? null;
        $member->designation = $reservation['designation'] ?? null;
        $member->slimID =  null;
        $member->other = null;
        
        $member->save();
        
      
        $ticket = new Ticket();
        $ticket->member_id = $member->id; // Assuming tickets table has a foreign key for members
        $ticket->Numberof_ticket = $reservation['tickets'];
        $ticket->AgentID = null;
        $ticket->TotalPrice	=$reservation['grandTotal'];
        $ticket->DiscountPrice=$reservation['discount'];
        $ticket->Date=$currentDate;
        $ticket->PaymentStatus='0';
        $ticket->IssuedStatus='1';
        $ticket->IncentivePrice=null;
        $ticket->PaymentType='card';
        $ticket->other = null;
       
        $ticket->save();
        
        try {
            // Prepare payment request data
            $paymentData = [
                'merchant_id' => $this->merchantId,
                'order_id' => 'RES-' . $reservation['id'],
                'amount' => $reservation['grandTotal'],
                'currency' => 'LKR',
                'customer_name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'customer_email' => $validatedData['email'],
                'card_number' => $this->maskCardNumber($validatedData['card_number']),
                'return_url' => route('payment.callback'),
                'cancel_url' => route('checkout'),
                'transaction_type' => 'PURCHASE'
            ];

            // Send request to HNB Payment Gateway
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($this->gatewayUrl . '/initiate-payment', $paymentData);

            // Check response
            if ($response->successful()) {
                $responseData = $response->json();

                // Log transaction for tracking
                Log::info('HNB Payment Initiated', [
                    'order_id' => $paymentData['order_id'],
                    'transaction_id' => $responseData['transaction_id']
                ]);

                // Redirect to HNB's payment page
                return redirect($responseData['payment_url']);
            } else {
                // Handle payment initiation failure
                Log::error('Payment Initiation Failed', [
                    'response' => $response->body(),
                    'order_id' => $paymentData['order_id']
                ]);

                return redirect()->route('checkout')
                    ->with('error', 'Payment processing failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error('Payment Processing Error: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'An unexpected error occurred during payment.');
        }
    }

    public function paymentCallback(Request $request)
    {
        // Validate callback from HNB Gateway
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');

        try {
            // Verify transaction with HNB
            $verificationResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey
            ])->get($this->gatewayUrl . "/verify-transaction/{$transactionId}");

            if ($verificationResponse->successful()) {
                $transactionDetails = $verificationResponse->json();

                if ($transactionDetails['status'] === 'SUCCESS') {
                    // Update reservation status
                    $reservation = session('reservation');
                    $this->updateReservationStatus($reservation['id'], 'PAID');

                    // Clear session
                    $request->session()->forget('reservation');

                    return redirect()->route('booking.confirmation')
                        ->with('success', 'Payment successful!');
                } else {
                    return redirect()->route('checkout')
                        ->with('error', 'Payment verification failed.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Payment Callback Error: ' . $e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Payment verification encountered an issue.');
        }
    }

    // Utility method to mask card number for logging
    private function maskCardNumber($cardNumber)
    {
        return str_repeat('*', strlen($cardNumber) - 4) . substr($cardNumber, -4);
    }

    // Method to update reservation status in your database
    private function updateReservationStatus($reservationId, $status)
    {
        // Implement your database update logic here
        // Example: Reservation::find($reservationId)->update(['payment_status' => $status]);
    }
}