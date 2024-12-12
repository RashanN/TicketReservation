<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the count of members from the members table
        $totalTickets = Ticket::where('AgentID', Auth::user()->id)->sum('Numberof_ticket');
        $totalPrice = Ticket::where('AgentID', Auth::user()->id)->sum('TotalPrice');
        $totalIncentive = Ticket::where('AgentID', Auth::user()->id)->sum('IncentivePrice');
        $tickets = Ticket::where('AgentID', Auth::user()->id)
                         ->with('member')  // Eager load the associated member
                         ->get();
        // Pass the count to the dashboard view
        return view('dashboard', compact('totalTickets','totalPrice','totalIncentive','tickets'));
    }
    public function adminDashboard()
    {
        $totalTickets = Ticket::sum('Numberof_ticket');
        $totalPrice = Ticket::sum('TotalPrice');
        $totalIncentive = Ticket::sum('IncentivePrice');
        $tickets = Ticket::with('member')  // Eager load the associated member
                         ->get();
        // You can pass any data that is needed for the admin dashboard view
        return view('admin.dashboard' ,compact('totalTickets','totalPrice','totalIncentive','tickets'));
    }
}
