<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Ticket;
use App\Models\CoupenCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\TicketDraftMail;
use App\Mail\IssuedTicketMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    //
    public function reserveTickets(Request $request)
    {
       
      
      
        // Validate the form inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nic' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'company' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'tickets' => 'required|integer|min:1',
            'slimid' => 'nullable|string|max:255',
        ]);
        $currentDate = Carbon::now()->toDateString();
        
        $totalTickets = Ticket::sum('Numberof_ticket');
        if ($totalTickets + $validatedData['tickets'] > 500) {
            return redirect()->back()->with('error', 'All tickets are sold out.');
        }
        $grandTotal = $request->grandTotal;
        $incentive = 0;
    
        switch ($request->rateType) {
            case 'slimMember':
            case 'slimStudent':
            case 'corporateDiscount':
                $incentive = 0.05 * $grandTotal; // 5% incentive
                break;
    
            case 'normalRate':
                $incentive = 0.125 * $grandTotal; // 12.5% incentive
                break;
    
            default:
                $incentive = 0; // No incentive for invalid rateType
                break;
        }

        
            



        $member = new Member();
        $member->name = $validatedData['name'];
        $member->email = $validatedData['email'];
        $member->phone = $validatedData['phone'];
        $member->nic = $validatedData['nic'];
        $member->company_name = $validatedData['company'] ?? null;
        $member->designation = $validatedData['designation'] ?? null;
        $member->slimID = $validatedData['slimid'] ?? null;
        $member->other = null;
        $member->save();

        $request->rateType;

        // Save the data to the tickets table
        $ticket = new Ticket();
        $ticket->member_id = $member->id; // Assuming tickets table has a foreign key for members
        $ticket->Numberof_ticket = $validatedData['tickets'];
        $ticket->AgentID = Auth::user()->id;
        $ticket->TotalPrice	=$request->grandTotal;
        $ticket->DiscountPrice=$request->discount;
        $ticket->Date=$currentDate;
        $ticket->PaymentStatus='0';
        $ticket->IssuedStatus='0';
        $ticket->IncentivePrice=$incentive;
        $ticket->PaymentType=$request->paymentType;
        $ticket->other = null;
        
        $ticket->save();

        Mail::to($member->email)->send(new TicketDraftMail($member));
        
        $request->session()->put('referenceNumber', $ticket->id);

        // Redirect to the success page
        return redirect()->route('reservation.success');

    }

    public function showSuccessPage(Request $request)
    {
       
        // Retrieve the reference number from the session
        $referenceNumber = $request->session()->get('referenceNumber');
    
        // If no reference number is found, redirect to another page (optional)
       
    
        // Pass the reference number to the view
        return view('admin.success', compact('referenceNumber'));
    }
    public function updatePaymentStatus($ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->PaymentStatus = '1';
            $ticket->save();
    
            return redirect()->back()->with('success', 'Payment status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update payment status: ' . $e->getMessage());
        }
    }
    
    public function updateIssuedStatus($ticketId)
{
    try {
        $ticket = Ticket::with('member')->findOrFail($ticketId);

        // Get all coupon codes associated with this ticket
        $couponCodes = CoupenCode::where('ticket_id', $ticket->id)->get();

        // Collect all coupon images as public URLs
        $generatedImages = $couponCodes->pluck('image')->map(function ($imagePath) {
            return asset($imagePath); // Generate public URL for each image
        })->toArray();
        
        // Update issued status
        $ticket->IssuedStatus = '1';
        $ticket->save();

        $member = Member::findOrFail($ticket->member_id);

        // Send an email with the QR codes
        Mail::to($member->email)->send(new IssuedTicketMail($member, $ticket, $generatedImages));

        return redirect()->back()->with('success', 'QR codes sent successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to send QR codes: ' . $e->getMessage());
    }
}
    
    public function destroy($id)
    {
       
        $ticket = Ticket::findOrFail($id);
        
        
        $ticket->delete();

      
        return redirect()->back()->with('success', 'Payment status updated successfully');

        
       
    }
    public function storeDraft(Request $request)
    {
      // dd($request);
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'nic' => 'required|string',
            'phone' => 'required|string',
            'company' => 'nullable|string',
            'designation' => 'nullable|string',
            'tickets' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'grandTotal' => 'required|numeric|min:0',
        ]);
        
        $request->session()->put('reservation', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nic' => $request->input('nic'),
            'phone' => $request->input('phone'),
            'company' => $request->input('company'),
            'designation' => $request->input('designation'),
            'tickets' => $request->input('tickets'),
             'total'=>$request->input('total'),
             'discount'=>$request->input('discount'),
             'grandTotal'=>$request->input('grandTotal'),
        ]);

        
        

        // Redirect to the checkout page with the reservation ID
        return redirect()->route('checkout');
    }
    public function checkout(Request $request)
    {
       
        $reservation = $request->session()->get('reservation');
        $email = $reservation['email'];
        $phone=$reservation['phone'];
        $name=$reservation['name'];
        $grandTotal=$reservation['grandTotal'];
        if (!$reservation) {
            // If there's no reservation data in the session, redirect back
            return redirect()->route('welcome')->with('error', 'No reservation data found.');
        }

        // Pass the reservation data to the checkout view
        return view('checkout', compact('reservation','email','grandTotal','name','phone'));
    }
    public function saveQRCode(Request $request)
{
    $ticketId = $request->input('ticketId');
    $uniqueCode = $request->input('uniqueCode');
    $qrImageData = $request->input('qrImageData');

    // Remove the base64 image prefix
    $imageData = str_replace('data:image/png;base64,', '', $qrImageData);
    $imageData = base64_decode($imageData);

    // Save the QR code image to the public directory
    $qrCodePath = public_path('qrcodes/' . $uniqueCode . '.png');
    file_put_contents($qrCodePath, $imageData);

    // Save the QR code details to the database (CoupenCode table)
    CoupenCode::create([
        'code' => $uniqueCode,
        'ticket_id' => $ticketId,
        'image' => 'qrcodes/' . $uniqueCode . '.png',
    ]);

    return response()->json(['success' => true, 'message' => 'QR code saved successfully']);
}

}
