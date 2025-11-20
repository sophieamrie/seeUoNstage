<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['booking_code', 'user_id', 'event_id', 'ticket_type_id', 'quantity', 'total_price', 'status', 'booked_at', 'approved_at', 'cancelled_at', 'cancellable_until'];
    public function user() { return $this->belongsTo(User::class); }
    public function event() { return $this->belongsTo(Event::class); }
    public function ticketType() { return $this->belongsTo(TicketType::class,'ticket_type_id'); }
    public function tickets() { return $this->hasMany(Ticket::class); }
}
