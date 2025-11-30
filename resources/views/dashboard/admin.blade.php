@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Events -->
    <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-1">Total Events</p>
                <p class="text-3xl font-bold text-white">{{ $totalEvents }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-1">Total Bookings</p>
                <p class="text-3xl font-bold text-white">{{ $totalBookings }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                <i class="fas fa-ticket-alt text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Organizers -->
    <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-1">Pending Organizers</p>
                <p class="text-3xl font-bold text-white">{{ $pendingOrganizers }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-lg">
                <i class="fas fa-user-clock text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="glass rounded-2xl border border-white/10 overflow-hidden">
        <div class="p-6 border-b border-white/10 bg-white/5 backdrop-blur-sm">
            <h3 class="text-xl font-bold text-white">Recent Users</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between hover:bg-white/5 p-3 rounded-xl transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $user->name }}</p>
                            <p class="text-sm text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full font-medium border
                        @if($user->role === 'admin') bg-red-500/20 border-red-500/50 text-red-300
                        @elseif($user->role === 'organizer') bg-blue-500/20 border-blue-500/50 text-blue-300
                        @else bg-gray-500/20 border-gray-500/50 text-gray-300
                        @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-center py-8">No users yet</p>
                @endforelse
            </div>
            <a href="{{ route('admin.users.index') }}" class="block text-center mt-6 text-purple-400 hover:text-purple-300 font-medium transition group">
                View All Users 
                <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 inline-block transition-transform"></i>
            </a>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="glass rounded-2xl border border-white/10 overflow-hidden">
        <div class="p-6 border-b border-white/10 bg-white/5 backdrop-blur-sm">
            <h3 class="text-xl font-bold text-white">Recent Events</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentEvents as $event)
                <div class="flex items-center justify-between hover:bg-white/5 p-3 rounded-xl transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $event->title }}</p>
                            <p class="text-sm text-gray-400">{{ $event->start_datetime->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-300 flex items-center">
                        <i class="fas fa-map-marker-alt text-red-400 mr-1"></i>
                        {{ Str::limit($event->location, 15) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-center py-8">No events yet</p>
                @endforelse
            </div>
            <a href="{{ route('admin.events.index') }}" class="block text-center mt-6 text-purple-400 hover:text-purple-300 font-medium transition group">
                View All Events 
                <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 inline-block transition-transform"></i>
            </a>
        </div>
    </div>
</div>
@endsection