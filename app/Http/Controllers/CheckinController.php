<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Checkin;
use App\Models\CoupenCode;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    // Show the confirmation page
    public function showConfirmationPage(Request $request)
    {
        $code = $request->get('code'); 
      
      
        $coupen = CoupenCode::where('code', $code)->first();
    
        if (!$coupen) {
           
            return view('checkin.error', ['message' => 'Invalid or expired coupon code.']);
        }
    
        $today = Carbon::today(); // Get today's date using Carbon

        $existingCheckin = Checkin::where('coupen_id', $coupen->id)
                                  ->whereDate('day1', $today) // Compare only the date part
                                  ->first();
    
        
        if ($existingCheckin) {
            return view('checkin.error', ['message' => 'This coupon has already been checked in today.']);
        }
    
        
        return view('checkin.confirm', compact('coupen'));
    }   
    



    public function confirmCheckin(Request $request)
    {
        
        $coupenId = $request->input('coupen_id');

       
        $coupen = CoupenCode::find($coupenId);

    
        if (!$coupen) {
            return redirect()->back()->with('error', 'Coupon not found.');
        }

       
        $ticketId = $coupen->ticket_id;

      
        $ticket = Ticket::find($ticketId);

      
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        $memberId = $ticket->member_id;

       
        $checkin = new Checkin();
        $checkin->ticket_id = $ticketId;
        $checkin->member_id = $memberId;
        $checkin->coupen_id = $coupenId;

       
        $checkin->day1 = Carbon::today(); 

       
        $checkinSaved = $checkin->save();

       
        if ($checkinSaved) {
            return redirect()->back()->with('success', 'Check-in confirmed successfully.');
        } else {
            return redirect()->back()->with('error', 'Check-in failed. Please try again.');
        }
    }
    public function index()
    {
        $checkins = Checkin::with(['ticket', 'member', 'coupen'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('checkin.index', compact('checkins'));
    }
}
