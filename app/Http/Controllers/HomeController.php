<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addWeek();
        
        $query = Event::query()->where('is_published', true);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        return view('welcome', [
            'latestEvents' => $query->latest()->take(10)->get(),
            'thisWeekEvents' => Event::where('is_published', true)
                                    ->whereBetween('start_datetime', [$today, $nextWeek])
                                    ->orderBy('start_datetime', 'asc')
                                    ->take(6)
                                    ->get(),
        ]);
    }
}