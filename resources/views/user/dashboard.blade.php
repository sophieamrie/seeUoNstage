@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-purple-100">Discover amazing concerts and book your tickets today</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-music text-6xl opacity-20"></i>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Total Bookings --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ auth()->user()->bookings()->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Total Bookings</p>
        </div>

        {{-- Pending Bookings --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ auth()->user()->bookings()->where('status', 'pending')->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Pending Approval</p>
        </div>

        {{-- Favorite Events --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-red-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ auth()->user()->favorites()->count() }}</h3>
            <p class="text-sm text-gray-600 mt-1">Favorite Events</p>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            {{-- Browse Events --}}
            <a href="{{ route('events.index') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-search text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Browse Events</h3>
                    <p class="text-sm text-gray-600">Find concerts near you</p>
                </div>
            </a>

            {{-- My Bookings --}}
            <a href="{{ route('bookings.index') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-ticket-alt text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">My Bookings</h3>
                    <p class="text-sm text-gray-600">View booking history</p>
                </div>
            </a>

            {{-- Favorites --}}
            <a href="{{ route('favorites.index') }}" class="flex items-center p-4 bg-pink-50 hover:bg-pink-100 rounded-lg transition group">
                <div class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition">
                    <i class="fas fa-heart text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Favorites</h3>
                    <p class="text-sm text-gray-600">Saved events</p>
                </div>
            </a>

        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Recent Bookings</h2>
            <a href="{{ route('bookings.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @php
            $recentBookings = auth()->user()->bookings()->with('event')->latest()->take(5)->get();
        @endphp

        @if($recentBookings->count() > 0)
        <div class="divide-y">
            @foreach($recentBookings as $booking)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        @if($booking->event->image_url)
                        <img src="{{ asset('storage/' . $booking->event->image_url) }}" alt="{{ $booking->event->title }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-music text-white"></i>
                        </div>
                        @endif
                        
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $booking->event->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $booking->quantity }} ticket(s) • Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div>
                        @if($booking->status === 'pending')
                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @elseif($booking->status === 'approved')
                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif($booking->status === 'rejected')
                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                            {{ ucfirst($booking->status) }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-ticket-alt text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Bookings Yet</h3>
            <p class="text-gray-600 mb-6">Start exploring concerts and book your first ticket!</p>
            <a href="{{ route('events.index') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-search mr-2"></i>Browse Events
            </a>
        </div>
        @endif
    </div>

</div>
@endsection