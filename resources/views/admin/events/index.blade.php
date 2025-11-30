@extends('layouts.admin')

@section('title', 'Manage Events')
@section('page-title', 'Event Management')

@section('content')
<!-- Create Event Button -->
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.events.create') }}" class="px-6 py-2.5 bg-white text-gray-900 rounded-xl font-semibold hover:bg-gray-100 transition">
        <i class="fas fa-plus mr-2"></i>Create Event
    </a>
</div>

<!-- Events Table -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-white">All Events</h3>
            <p class="text-sm text-gray-400 mt-1">Total: <span class="text-white font-semibold">{{ $events->total() }}</span></p>
        </div>
    </div>

    @if($events->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Event</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Organizer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Location</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($events as $event)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-16 h-16 object-cover rounded-xl">
                            @else
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-image text-white text-xl"></i>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-white">{{ Str::limit($event->title, 30) }}</p>
                                @if($event->artist)
                                <p class="text-sm text-gray-400">{{ Str::limit($event->artist, 25) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($event->category)
                        <span class="px-3 py-1 text-xs bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded-lg font-semibold">{{ $event->category }}</span>
                        @else
                        <span class="text-gray-600">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        {{ $event->organizer->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-white font-medium">{{ $event->start_datetime->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-400">{{ $event->start_datetime->format('h:i A') }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                            {{ Str::limit($event->location, 20) }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($event->is_published)
                        <span class="px-3 py-1 text-xs bg-green-500/20 text-green-300 border border-green-500/30 rounded-lg font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Published
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs bg-gray-500/20 text-gray-300 border border-gray-500/30 rounded-lg font-semibold">
                            <i class="fas fa-eye-slash mr-1"></i>Draft
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="w-8 h-8 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 rounded-lg transition flex items-center justify-center border border-blue-500/30" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition flex items-center justify-center border border-red-500/30" title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
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
    <div class="p-6 border-t border-white/10">
        {{ $events->links() }}
    </div>
    @endif
    @else
    <div class="p-12 text-center">
        <div class="w-20 h-20 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
            <i class="fas fa-calendar-alt text-gray-600 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">No Events Yet</h3>
        <p class="text-gray-400 mb-6">Get started by creating your first event</p>
        <a href="{{ route('admin.events.create') }}" class="inline-block px-6 py-3 bg-white text-gray-900 rounded-xl font-semibold hover:bg-gray-100 transition">
            <i class="fas fa-plus mr-2"></i>Create Event
        </a>
    </div>
    @endif
</div>
@endsection