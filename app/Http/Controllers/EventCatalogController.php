<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::published()->with('organizer');

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('artist', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->location . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('start_datetime', $request->date);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'latest':
                $query->latest('start_datetime');
                break;
            case 'oldest':
                $query->oldest('start_datetime');
                break;
            case 'name':
                $query->orderBy('title');
                break;
        }

        $events = $query->paginate(12);
        $categories = Event::published()->distinct()->pluck('category')->filter();
        $locations = Event::published()->distinct()->pluck('location')->filter();

        return view('events.index', compact('events', 'categories', 'locations'));
    }

    public function show(Event $event)
    {
        // Load ticket types with the event
        $event->load('ticketTypes');

        // Check if user has favorited this event
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = auth()->user()->favorites()->where('event_id', $event->id)->exists();
        }

        return view('events.show', compact('event', 'isFavorited'));
    }
}