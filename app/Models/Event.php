<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{

    use HasFactory;

    protected $fillable = ['organizer_id', 'title', 'description', 'category', 'artist', 'location', 'start_datetime', 'end_datetime', 'image_url', 'is_published'];
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function organizer() { return $this->belongsTo(User::class,'organizer_id'); }
    public function ticketTypes() { return $this->hasMany(TicketType::class); }
    public function ratings() { return $this->hasMany(EventRating::class); }
    public function scopePublished($query) { return $query->where('is_published', true); }
}
