<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index()
    {
        // Get all events
        $events = Event::all();
        
        // Get all ticket types with their events
        $ticketTypes = TicketType::with('event')
                                  ->latest()
                                  ->paginate(15);

        return view('admin.ticket-types.index', compact('ticketTypes', 'events'));
    }

    public function create()
    {
        $events = Event::all();
        
        if ($events->isEmpty()) {
            return redirect()->route('admin.events.create')
                           ->with('error', 'Please create an event first before adding tickets.');
        }

        return view('admin.ticket-types.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('tickets', 'public');
        }

        $validated['remaining_quota'] = $validated['quota'];
        $validated['status'] = 'pending'; // New tickets start as pending

        TicketType::create($validated);

        return redirect()->route('admin.ticket-types.index')
                       ->with('success', 'Ticket type created successfully!');
    }

    public function edit(TicketType $ticketType)
    {
        $events = Event::all();
        return view('admin.ticket-types.edit', compact('ticketType', 'events'));
    }

    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('tickets', 'public');
        }

        $ticketType->update($validated);

        return redirect()->route('admin.ticket-types.index')
                       ->with('success', 'Ticket type updated successfully!');
    }

    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return redirect()->route('admin.ticket-types.index')
                       ->with('success', 'Ticket type deleted successfully!');
    }

    // ADD THESE NEW METHODS:
    public function approve(TicketType $ticketType)
    {
        $ticketType->update(['status' => 'approved']);
        
        return back()->with('success', 'Ticket type approved successfully!');
    }

    public function reject(TicketType $ticketType)
    {
        $ticketType->update(['status' => 'rejected']);
        
        return back()->with('success', 'Ticket type rejected.');
    }
}