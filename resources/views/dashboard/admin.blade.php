@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Events -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Events</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalEvents }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-ticket-alt text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Organizers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pending Organizers</p>
                <p class="text-3xl font-bold text-gray-800">{{ $pendingOrganizers }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-clock text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full 
                        @if($user->role === 'admin') bg-red-100 text-red-700
                        @elseif($user->role === 'organizer') bg-blue-100 text-blue-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No users yet</p>
                @endforelse
            </div>
            <a href="{{ route('admin.users.index') }}" class="block text-center mt-4 text-purple-600 hover:text-purple-800 font-medium">
                View All Users →
            </a>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Recent Events</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentEvents as $event)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $event->title }}</p>
                            <p class="text-sm text-gray-500">{{ $event->start_datetime->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600">{{ $event->location }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No events yet</p>
                @endforelse
            </div>
            <a href="{{ route('admin.events.index') }}" class="block text-center mt-4 text-purple-600 hover:text-purple-800 font-medium">
                View All Events →
            </a>
        </div>
    </div>
</div>
@endsection