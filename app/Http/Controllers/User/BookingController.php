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
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {

            $ticket = TicketType::lockForUpdate()->find($request->ticket_type_id);

            if (!$ticket) {
                return back()->with('error', 'Ticket tidak ditemukan.');
            }

            if ($ticket->remaining_quota < $request->quantity) {
                return back()->with('error', 'Kuota tiket tidak mencukupi.');
            }

            // Reduce quota
            $ticket->remaining_quota -= $request->quantity;
            $ticket->save();

            $totalPrice = $ticket->price * $request->quantity;

            $booking = Booking::create([
                'booking_code'      => 'BK-' . strtoupper(uniqid()),
                'user_id'           => auth()->id(),
                'event_id'          => $ticket->event_id,
                'ticket_type_id'    => $ticket->id,
                'quantity'          => $request->quantity,
                'total_price'       => $totalPrice,
                'status'            => 'PENDING',
                'booked_at'         => now(),
                'cancellable_until' => now()->addHours(24),
            ]);

            return redirect()->route('user.bookings.success', $booking->id);
        });
    }


    // -------------------------------------------------
    // SUCCESS PAGE
    // -------------------------------------------------
    public function success($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.bookings.success', compact('booking'));
    }
}
