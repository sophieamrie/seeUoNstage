@extends('layouts.organizer')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Edit Event</h1>
        <p class="text-gray-400">Update your event details below</p>
    </div>

    <form action="{{ route('organizer.events.update', $event->id) }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">

        @csrf
        @method('PUT')

        <!-- Event Details Section -->
        <div class="glass p-6 rounded-2xl border border-white/10 space-y-6">
            <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle text-purple-400"></i>
                </div>
                Event Details
            </h2>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Title *</label>
                <input type="text" name="title" 
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                       value="{{ old('title', $event->title) }}" 
                       placeholder="Enter event title"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Description *</label>
                <textarea name="description" 
                          class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                          rows="5" 
                          placeholder="Describe your event in detail..."
                          required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Category</label>
                    <input type="text" name="category" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                           value="{{ old('category', $event->category) }}"
                           placeholder="e.g., Concert, Festival">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Artist</label>
                    <input type="text" name="artist" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                           value="{{ old('artist', $event->artist) }}"
                           placeholder="Performing artist name">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Location *</label>
                <input type="text" name="location" 
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                       value="{{ old('location', $event->location) }}" 
                       placeholder="Event venue location"
                       required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Start Datetime *</label>
                    <input type="datetime-local" name="start_datetime" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                           value="{{ old('start_datetime', $event->start_datetime->format('Y-m-d\TH:i')) }}" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">End Datetime</label>
                    <input type="datetime-local" name="end_datetime" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                           value="{{ old('end_datetime', $event->end_datetime ? $event->end_datetime->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Event Image</label>
                @if ($event->image_url)
                    <div class="mb-4">
                        <p class="text-sm text-gray-400 mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             class="w-48 h-32 object-cover rounded-xl border border-white/10 shadow-lg">
                    </div>
                @endif
                <div class="relative">
                    <input type="file" name="image" accept="image/*" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 focus:outline-none">
                </div>
                <p class="text-gray-400 text-xs mt-2">Leave empty to keep current image. Recommended: 1920x1080px, JPG or PNG, max 2MB</p>
            </div>

            <!-- Publish Toggle -->
            <div class="glass p-4 rounded-xl border border-white/10">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" 
                           {{ old('is_published', $event->is_published) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-white/20 bg-white/5 text-purple-600 focus:ring-2 focus:ring-purple-500/20">
                    <span class="ml-3 text-white font-medium">Publish this event</span>
                    <span class="ml-2 text-gray-400 text-sm">(Make it visible to the public)</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg hover:shadow-purple-500/50 text-white px-6 py-3 rounded-full font-semibold transition flex items-center justify-center">
                <i class="fas fa-save mr-2"></i>Update Event
            </button>
            <a href="{{ route('organizer.events.index') }}" class="flex-1 glass hover:bg-white/10 text-white px-6 py-3 rounded-full font-semibold transition flex items-center justify-center">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>

</div>
@endsection