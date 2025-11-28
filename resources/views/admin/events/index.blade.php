@extends('layouts.admin')

@section('title', 'Manage Events')
@section('page-title', 'Manage Events')

@section('content')
<!-- Create Event Button (moved to content area) -->
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
        <i class="fas fa-plus mr-2"></i>Create Event
    </a>
</div>

<!-- Events Grid -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">All Events ({{ $events->total() }})</h3>
        <div class="flex space-x-2">
            <input type="text" placeholder="Search events..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>

    @if($events->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-white text-xl"></i>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                                @if($event->artist)
                                <p class="text-sm text-gray-500">{{ $event->artist }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($event->category)
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">{{ $event->category }}</span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $event->organizer->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-800 font-medium">{{ $event->start_datetime->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $event->start_datetime->format('h:i A') }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                        {{ $event->location }}
                    </td>
                    <td class="px-6 py-4">
                        @if($event->is_published)
                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Published
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                            <i class="fas fa-eye-slash mr-1"></i>Draft
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <i class="fas fa-trash"></i>
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
    <div class="p-6 border-t">
        {{ $events->links() }}
    </div>
    @else
    <div class="p-12 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Events Yet</h3>
        <p class="text-gray-600 mb-4">Get started by creating your first event</p>
        <a href="{{ route('admin.events.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-plus mr-2"></i>Create Event
        </a>
    </div>
    @endif
</div>
@endsection