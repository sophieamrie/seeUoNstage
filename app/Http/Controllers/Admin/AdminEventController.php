<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::with('organizer')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:255',
            'artist' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'image_url' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'ticket_types' => 'required|array|min:1',
            'ticket_types.*.name' => 'required|string|max:255',
            'ticket_types.*.price' => 'required|numeric|min:0',
            'ticket_types.*.quota' => 'required|integer|min:1',
            'ticket_types.*.description' => 'nullable|string',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('events', 'public');
        }

        $validated['organizer_id'] = auth()->id();
        $validated['is_published'] = $request->has('is_published');

        $event = Event::create($validated);

        // Create ticket types with pending status
        foreach ($request->ticket_types as $ticketData) {
            $event->ticketTypes()->create([
                'name' => $ticketData['name'],
                'price' => $ticketData['price'],
                'quota' => $ticketData['quota'],
                'description' => $ticketData['description'] ?? null,
                'sold' => 0,
                'is_available' => true,
                'status' => 'pending', // Start as pending
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event and ticket types created successfully! Ticket types are pending approval.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:255',
            'artist' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('events', 'public');
        }

        $validated['is_published'] = $request->has('is_published');

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }
}