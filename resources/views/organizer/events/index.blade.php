@extends('layouts.organizer')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-bold">My Events</h1>
        <a href="{{ route('organizer.events.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">+ Create Event</a>
    </div>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded p-4">
        <table class="w-full border-collapse">
            <thead class="border-b font-semibold">
                <tr>
                    <th class="p-2 text-left">Image</th>
                    <th class="p-2 text-left">Title</th>
                    <th class="p-2 text-left">Location</th>
                    <th class="p-2 text-left">Start</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr class="border-b">
                        <td class="p-2">
                            @if ($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" class="w-20 h-14 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>

                        <td class="p-2">{{ $event->title }}</td>

                        <td class="p-2">{{ $event->location }}</td>

                        <td class="p-2">
                            {{ date('d M Y H:i', strtotime($event->start_datetime)) }}
                        </td>

                        <td class="p-2">
                            <a href="{{ route('organizer.events.edit', $event->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('organizer.events.destroy', $event->id) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline ml-3">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
