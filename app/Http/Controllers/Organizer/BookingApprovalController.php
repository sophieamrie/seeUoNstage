<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingApprovalController extends Controller
{
    public function index()
    {
        // Get all bookings for events created by this organizer
        $bookings = Booking::whereHas('event', function($query) {
            $query->where('organizer_id', auth()->id());
        })
        ->with(['event', 'user', 'ticketType'])
        ->latest()
        ->get();

        return view('organizer.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        // Make sure this booking belongs to organizer's event
        if ($booking->event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking approved successfully!');
    }

    public function reject(Booking $booking)
    {
        // Make sure this booking belongs to organizer's event
        if ($booking->event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $booking->update(['status' => 'rejected']);

        // Optionally restore ticket quota
        if ($booking->ticketType) {
            $booking->ticketType->increment('quota');
        }

        return back()->with('success', 'Booking rejected successfully!');
    }
}