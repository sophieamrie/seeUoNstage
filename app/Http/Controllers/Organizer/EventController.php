<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller{
    public function index(){
        $events = Event::where('organizer_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('organizer.events.index', compact('events'));
    }

    public function create(){
        return view('organizer.events.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'category'      => 'nullable|string|max:100',
            'artist'        => 'nullable|string|max:150',
            'location'      => 'required|string|max:255',
            'start_datetime'=> 'required|date',
            'end_datetime'  => 'nullable|date|after_or_equal:start_datetime',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')){
            $validated['image_url'] = $request->file('image')->store('events', 'public');
        }

        $validated['organizer_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event){
        $this->authorizeEventOwner($event);
            return view('organizer.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event){
        $this->authorizeEventOwner($event);

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'category'      => 'nullable|string|max:100',
            'artist'        => 'nullable|string|max:150',
            'location'      => 'required|string|max:255',
            'start_datetime'=> 'required|date',
            'end_datetime'  => 'nullable|date|after_or_equal:start_datetime',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_url){
                Storage::disk('public')->delete($event->image_url);
            }

            $validated['image_url'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event){
        $this->authorizeEventOwner($event);

        if ($event->image_url) {
            Storage::disk('public')->delete($event->image_url);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'event deleted successfully!');
    }

    private function authorizeEventOwner(Event $event){
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'You are not allowed to modify this event');
        }
    }
}