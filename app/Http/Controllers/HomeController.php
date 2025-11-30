<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addWeek();
        
        return view('welcome', [
            // Latest events (newest first)
            'latestEvents' => Event::where('start_datetime', '>=', $today)
                                   ->latest()
                                   ->take(10)
                                   ->get(),
            
            // This week's events (next 7 days, chronologically)
            'thisWeekEvents' => Event::whereBetween('start_datetime', [$today, $nextWeek])
                                     ->orderBy('start_datetime', 'asc')
                                     ->take(6)
                                     ->get(),
        ]);
    }
}