<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // -------------------------------------------------
    // SHOW USER BOOKINGS LIST
    // -------------------------------------------------
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['event', 'ticketType'])
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }


    // -------------------------------------------------
    // STORE BOOKING
    // -------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        return DB::transaction(function () use ($request) {

            $ticketType = TicketType::lockForUpdate()->find($request->ticket_type_id);

            if (!$ticketType) {
                return back()->with('error', 'Ticket type not found.');
            }

            // Calculate available tickets
            $available = $ticketType->quota - $ticketType->sold;

            if ($available < $request->quantity) {
                return back()->with('error', 'Not enough tickets available. Only ' . $available . ' tickets left.');
            }

            // Calculate total price
            $totalPrice = $ticketType->price * $request->quantity;

            // Create booking
            $booking = Booking::create([
                'booking_code'      => 'BK-' . strtoupper(uniqid()),
                'user_id'           => auth()->id(),
                'event_id'          => $request->event_id,
                'ticket_type_id'    => $ticketType->id,
                'quantity'          => $request->quantity,
                'total_price'       => $totalPrice,
                'status'            => 'pending',
                'booked_at'         => now(),
                'cancellable_until' => now()->addHours(24),
            ]);

            // Increment sold count
            $ticketType->increment('sold', $request->quantity);

            // Also update remaining_quota if you're using it
            if ($ticketType->remaining_quota !== null) {
                $ticketType->decrement('remaining_quota', $request->quantity);
            }

            return redirect()->route('bookings.index')
                ->with('success', 'Booking created successfully! Waiting for organizer approval.');
        });
    }


    // -------------------------------------------------
    // SUCCESS PAGE
    // -------------------------------------------------
    public function success($id)
        {
            $booking = Booking::where('id', $id)
                ->where('user_id', auth()->id())
                ->with(['event', 'ticketType'])
                ->firstOrFail();

            return view('user.bookings.success', compact('booking'));
        }

        public function show(Booking $booking)
    {
        // Make sure user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Only show approved bookings
        if (strtolower($booking->status) !== 'approved') {
            return redirect()->route('bookings.index')
                ->with('error', 'This booking is not approved yet.');
        }

        return view('user.bookings.show', compact('booking'));
    }

    // -------------------------------------------------
    // CANCEL BOOKING
    // -------------------------------------------------
    public function cancel(Booking $booking)
    {
        // Make sure user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Can only cancel pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending bookings.');
        }

        // Check if still within cancellable period
        if (now()->greaterThan($booking->cancellable_until)) {
            return back()->with('error', 'Cancellation period has expired.');
        }

        DB::transaction(function () use ($booking) {
            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            // Return tickets to quota
            $booking->ticketType->decrement('sold', $booking->quantity);
            
            if ($booking->ticketType->remaining_quota !== null) {
                $booking->ticketType->increment('remaining_quota', $booking->quantity);
            }
        });

        return back()->with('success', 'Booking cancelled successfully.');
    }
}