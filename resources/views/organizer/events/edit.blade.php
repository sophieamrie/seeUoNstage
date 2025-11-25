@extends('layouts.organizer')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-5">Edit Event</h1>

    <form action="{{ route('organizer.events.update', $event->id) }}"
          method="POST" enctype="multipart/form-data" class="space-y-4">

        @csrf
        @method('PUT')

        <div>
            <label class="font-semibold">Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded"
                   value="{{ old('title', $event->title) }}" required>
        </div>

        <div>
            <label class="font-semibold">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="4" required>
                {{ old('description', $event->description) }}
            </textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Category</label>
                <input type="text" name="category" class="w-full border p-2 rounded"
                       value="{{ old('category', $event->category) }}">
            </div>
            <div>
                <label class="font-semibold">Artist</label>
                <input type="text" name="artist" class="w-full border p-2 rounded"
                       value="{{ old('artist', $event->artist) }}">
            </div>
        </div>

        <div>
            <label class="font-semibold">Location</label>
            <input type="text" name="location" class="w-full border p-2 rounded"
                   value="{{ old('location', $event->location) }}" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Start Datetime</label>
                <input type="datetime-local" name="start_datetime" class="w-full border p-2 rounded"
                       value="{{ old('start_datetime', str_replace(' ', 'T', $event->start_datetime)) }}" required>
            </div>
            <div>
                <label class="font-semibold">End Datetime</label>
                <input type="datetime-local" name="end_datetime" class="w-full border p-2 rounded"
                       value="{{ old('end_datetime', str_replace(' ', 'T', $event->end_datetime)) }}">
            </div>
        </div>

        <div>
            <label class="font-semibold">Event Image</label>
            @if ($event->image_url)
                <img src="{{ asset('storage/' . $event->image_url) }}" class="w-32 h-20 object-cover rounded mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-6 py-2 rounded">Update</button>

    </form>

</div>
@endsection
