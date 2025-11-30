@extends('layouts.organizer')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-purple-100 text-lg">Manage your events and track your bookings from your dashboard</p>
                </div>
                <div class="hidden md:block opacity-20">
                    <i class="fas fa-chart-line text-8xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Events -->
        <div class="glass rounded-2xl p-6 hover:bg-white/10 hover:-translate-y-1 transition group border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $events->count() }}</h3>
            <p class="text-sm text-gray-400">Events Created</p>
        </div>

        <!-- Published Events -->
        <div class="glass rounded-2xl p-6 hover:bg-white/10 hover:-translate-y-1 transition group border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $events->where('is_published', true)->count() }}</h3>
            <p class="text-sm text-gray-400">Published Events</p>
        </div>

        <!-- Draft Events -->
        <div class="glass rounded-2xl p-6 hover:bg-white/10 hover:-translate-y-1 transition group border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-eye-slash text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $events->where('is_published', false)->count() }}</h3>
            <p class="text-sm text-gray-400">Draft Events</p>
        </div>

        <!-- Upcoming Events -->
        <div class="glass rounded-2xl p-6 hover:bg-white/10 hover:-translate-y-1 transition group border border-white/10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $events->where('start_datetime', '>', now())->count() }}</h3>
            <p class="text-sm text-gray-400">Upcoming Events</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass rounded-2xl p-6 border border-white/10">
        <h2 class="text-2xl font-bold text-white mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('organizer.events.create') }}" class="glass border border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/10 rounded-xl p-6 transition hover:shadow-lg hover:shadow-purple-500/20 hover:-translate-y-1 group">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-plus text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-white mb-1">Create Event</h3>
                <p class="text-sm text-gray-400">Add a new event</p>
            </a>

            <a href="{{ route('organizer.events.index') }}" class="glass border border-blue-500/50 hover:border-blue-500 hover:bg-blue-500/10 rounded-xl p-6 transition hover:shadow-lg hover:shadow-blue-500/20 hover:-translate-y-1 group">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-list text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-white mb-1">Manage Events</h3>
                <p class="text-sm text-gray-400">View all events</p>
            </a>

            <a href="{{ route('organizer.bookings.index') }}" class="glass border border-green-500/50 hover:border-green-500 hover:bg-green-500/10 rounded-xl p-6 transition hover:shadow-lg hover:shadow-green-500/20 hover:-translate-y-1 group">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-white mb-1">View Bookings</h3>
                <p class="text-sm text-gray-400">Check orders</p>
            </a>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="glass rounded-2xl border border-white/10 overflow-hidden">
        <div class="p-6 border-b border-white/10 flex items-center justify-between backdrop-blur-sm">
            <h2 class="text-2xl font-bold text-white">Your Recent Events</h2>
            <a href="{{ route('organizer.events.index') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium transition group">
                View All 
                <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 inline-block transition-transform"></i>
            </a>
        </div>

        @if($events->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($events->take(5) as $event)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-12 h-12 object-cover rounded-xl mr-3 shadow-md">
                                @else
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-image text-white"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-bold text-white">{{ $event->title }}</p>
                                    @if($event->artist)
                                    <p class="text-sm text-gray-400">{{ $event->artist }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-white font-medium">{{ $event->start_datetime->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-400">{{ $event->start_datetime->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            <i class="fas fa-map-marker-alt text-red-400 mr-1"></i>
                            {{ Str::limit($event->location, 20) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($event->is_published)
                            <span class="px-4 py-2 text-xs bg-green-500/20 border border-green-500/50 text-green-300 rounded-full font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Published
                            </span>
                            @else
                            <span class="px-4 py-2 text-xs bg-gray-500/20 border border-gray-500/50 text-gray-300 rounded-full font-medium">
                                <i class="fas fa-eye-slash mr-1"></i>Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('organizer.events.edit', $event) }}" class="text-blue-400 hover:text-blue-300 transition" title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <a href="{{ route('organizer.events.show', $event) }}" class="text-green-400 hover:text-green-300 transition" title="View">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-purple-500/30">
                <i class="fas fa-calendar-alt text-purple-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No Events Yet</h3>
            <p class="text-gray-400 mb-8">Get started by creating your first event to showcase on our platform</p>
            <a href="{{ route('organizer.events.create') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full font-semibold hover:shadow-lg hover:shadow-purple-500/50 transition">
                <i class="fas fa-plus mr-2"></i>Create Your First Event
            </a>
        </div>
        @endif
    </div>

    <!-- Tips Section -->
    <div class="glass rounded-2xl p-6 border border-blue-500/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="flex items-start relative z-10">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg">
                <i class="fas fa-lightbulb text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white mb-3">Quick Tips for Success</h3>
                <ul class="space-y-3 text-gray-300">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Add high-quality images to make your events stand out</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Write detailed descriptions to help attendees know what to expect</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Respond quickly to booking requests to maintain high ratings</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Keep your event information up-to-date for better user experience</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection