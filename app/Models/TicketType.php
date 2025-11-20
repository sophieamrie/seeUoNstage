<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = ['event_id', 'name', 'description', 'price', 'quota', 'remaining_quota', 'image_url'];
    public function event(){ return $this->belongsTo(Event::class); }
    public function bookings(){ return $this->hasMany(Booking::class); }
}
