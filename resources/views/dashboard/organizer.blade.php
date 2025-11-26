@extends('layouts.organizer')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-purple-100">Manage your events and track your bookings from your dashboard</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $events->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Events Created</p>
        </div>

        <!-- Published Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Live</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $events->where('is_published', true)->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Published Events</p>
        </div>

        <!-- Draft Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye-slash text-yellow-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Drafts</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $events->where('is_published', false)->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Draft Events</p>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Coming</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $events->where('start_datetime', '>', now())->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Upcoming Events</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('organizer.events.create') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Create Event</h3>
                    <p class="text-sm text-gray-600">Add a new event</p>
                </div>
            </a>

            <a href="{{ route('organizer.events.index') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-list text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Manage Events</h3>
                    <p class="text-sm text-gray-600">View all events</p>
                </div>
            </a>

            <a href="{{ route('organizer.bookings.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-ticket-alt text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">View Bookings</h3>
                    <p class="text-sm text-gray-600">Check orders</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Your Recent Events</h2>
            <a href="{{ route('organizer.events.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($events->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($events->take(5) as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-12 h-12 object-cover rounded-lg mr-3">
                                @else
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-image text-white"></i>
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
                            <p class="text-gray-800">{{ $event->start_datetime->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $event->start_datetime->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                            {{ Str::limit($event->location, 20) }}
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
                                <a href="{{ route('organizer.events.edit', $event) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('organizer.events.show', $event) }}" class="text-green-600 hover:text-green-800" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Events Yet</h3>
            <p class="text-gray-600 mb-6">Get started by creating your first event to showcase on our platform</p>
            <a href="{{ route('organizer.events.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-plus mr-2"></i>Create Your First Event
            </a>
        </div>
        @endif
    </div>

    <!-- Tips Section -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg shadow p-6 border border-blue-100">
        <div class="flex items-start">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                <i class="fas fa-lightbulb text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Quick Tips for Success</h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                        <span>Add high-quality images to make your events stand out</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                        <span>Write detailed descriptions to help attendees know what to expect</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                        <span>Respond quickly to booking requests to maintain high ratings</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                        <span>Keep your event information up-to-date for better user experience</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection