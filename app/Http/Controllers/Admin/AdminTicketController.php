<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index()
    {
        return view('admin.ticket-types.index', [
            'ticketTypes' => TicketType::with('event')->paginate(15),
            'events' => Event::all(),
            'bookings' => Booking::with(['user', 'event.organizer', 'ticketType'])
                                ->latest()
                                ->get()
        ]);
    }

    public function approveBooking(Booking $booking)
    {
        $booking->update(['status' => 'approved']);
        return back()->with('success', 'Booking approved successfully!');
    }

    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'rejected']);
        return back()->with('success', 'Booking rejected.');
    }
    
    // ... rest of your existing methods (create, store, edit, update, destroy, approve, reject for ticket types)
}