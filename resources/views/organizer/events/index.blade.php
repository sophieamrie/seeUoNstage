@extends('layouts.organizer')

@section('title', 'My Events')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">My Events</h1>
            <p class="text-gray-400 mt-1">Manage and track all your events</p>
        </div>
        <a href="{{ route('organizer.events.create') }}"
           class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg hover:shadow-purple-500/50 transition flex items-center">
            <i class="fas fa-plus mr-2"></i>Create Event
        </a>
    </div>

    <!-- Events Table -->
    <div class="glass rounded-2xl border border-white/10 overflow-hidden">
        @if($events->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event Details</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($events as $event)
                    <tr class="hover:bg-white/5 transition">
                        <!-- Image -->
                        <td class="px-6 py-4">
                            @if ($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" 
                                     alt="{{ $event->title }}"
                                     class="w-20 h-14 object-cover rounded-xl shadow-md">
                            @else
                                <div class="w-20 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-image text-white"></i>
                                </div>
                            @endif
                        </td>

                        <!-- Event Details -->
                        <td class="px-6 py-4">
                            <p class="font-bold text-white">{{ $event->title }}</p>
                            @if($event->artist)
                            <p class="text-sm text-gray-400">{{ $event->artist }}</p>
                            @endif
                            @if($event->category)
                            <span class="inline-block mt-1 px-2 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs">
                                {{ $event->category }}
                            </span>
                            @endif
                        </td>

                        <!-- Location -->
                        <td class="px-6 py-4">
                            <div class="flex items-start text-gray-300">
                                <i class="fas fa-map-marker-alt text-red-400 mr-2 mt-1 flex-shrink-0"></i>
                                <span>{{ Str::limit($event->location, 30) }}</span>
                            </div>
                        </td>

                        <!-- Date & Time -->
                        <td class="px-6 py-4">
                            <p class="text-white font-medium">{{ $event->start_datetime->format('d M Y') }}</p>
                            <p class="text-sm text-gray-400">{{ $event->start_datetime->format('h:i A') }}</p>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($event->is_published)
                            <span class="px-3 py-1.5 text-xs bg-green-500/20 border border-green-500/50 text-green-300 rounded-full font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Published
                            </span>
                            @else
                            <span class="px-3 py-1.5 text-xs bg-gray-500/20 border border-gray-500/50 text-gray-300 rounded-full font-medium">
                                <i class="fas fa-eye-slash mr-1"></i>Draft
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('organizer.events.edit', $event->id) }}"
                                   class="text-green-400 hover:text-green-300 transition"
                                   title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('organizer.events.destroy', $event->id) }}"
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-300 transition"
                                            title="Delete">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="p-6 border-t border-white/10 bg-white/5">
            {{ $events->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-purple-500/30">
                <i class="fas fa-calendar-alt text-purple-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">No Events Yet</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                Start creating amazing events for your audience! Click the button below to create your first event.
            </p>
            <a href="{{ route('organizer.events.create') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full font-semibold hover:shadow-lg hover:shadow-purple-500/50 transition">
                <i class="fas fa-plus mr-2"></i>Create Your First Event
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Overview -->
    @if($events->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass rounded-xl p-6 border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Total Events</p>
                    <p class="text-3xl font-bold text-white">{{ $events->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl p-6 border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Published</p>
                    <p class="text-3xl font-bold text-white">{{ $events->where('is_published', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="glass rounded-xl p-6 border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Upcoming</p>
                    <p class="text-3xl font-bold text-white">{{ $events->where('start_datetime', '>', now())->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection