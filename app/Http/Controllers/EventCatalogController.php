<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()->where('is_published', true);
        
        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }
        
        // Filter by location
        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        $events = $query->latest()->paginate(12);
        
        // Get unique categories and locations for filters
        $categories = Event::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();
        
        $locations = Event::where('is_published', true)
            ->distinct()
            ->pluck('location')
            ->filter()
            ->values();
        
        return view('events.index', compact('events', 'categories', 'locations'));
    }

    public function show(Event $event)
    {
        // Load ticket types with the event
        $event->load('ticketTypes');
        
        // Increment view count (optional)
        $event->increment('views');
        
        return view('events.show', compact('event'));
    }
}