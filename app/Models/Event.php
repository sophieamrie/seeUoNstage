<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['organizer_id', 'title', 'description', 'category', 'artist', 'location', 'start_datetime', 'end_datetime', 'image_url', 'is_published'];

    public function organizer() { return $this->belongsTo(User::class,'organizer_id'); }
    public function ticketTypes() { return $this->hasMany(TicketType::class); }
    public function ratings() { return $this->hasMany(EventRating::class); }
}
