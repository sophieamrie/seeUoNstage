@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    {{-- Welcome Hero Section --}}
    <div class="relative rounded-3xl shadow-2xl p-8 md:p-12 text-white overflow-hidden" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,.03) 2px, rgba(255,255,255,.03) 4px), linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <div class="inline-block mb-3 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-sm font-medium">
                        ✨ Your concert hub
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-3">
                        Hey {{ auth()->user()->name }}! 👋
                    </h2>
                    <p class="text-purple-100 text-lg md:text-xl max-w-2xl">
                        Ready to discover your next favorite live experience?
                    </p>
                </div>
                
                <a href="{{ route('events.index') }}" class="bg-white text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition transform hover:scale-105 shadow-xl whitespace-nowrap">
                    Browse Events →
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Total Bookings --}}
        <div class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-blue-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/30">
                    <i class="fas fa-ticket-alt text-white text-2xl"></i>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2">{{ auth()->user()->bookings()->count() }}</h3>
                <p class="text-gray-300 font-semibold text-lg">Total Bookings</p>
                <p class="text-sm text-gray-500 mt-2">All-time reservations</p>
            </div>
        </div>

        {{-- Pending Bookings --}}
        <div class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-yellow-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-yellow-500/30">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2">{{ auth()->user()->bookings()->where('status', 'PENDING')->count() }}</h3>
                <p class="text-gray-300 font-semibold text-lg">Pending Approval</p>
                <p class="text-sm text-gray-500 mt-2">Awaiting confirmation</p>
            </div>
        </div>

        {{-- Favorite Events --}}
        <div class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-pink-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-pink-500/30">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                
                <h3 class="text-5xl font-bold text-white mb-2">{{ auth()->user()->favorites()->count() }}</h3>
                <p class="text-gray-300 font-semibold text-lg">Saved Events</p>
                <p class="text-sm text-gray-500 mt-2">Your favorites</p>
            </div>
        </div>

    </div>

    {{-- Quick Actions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Browse Events --}}
        <a href="{{ route('events.index') }}" class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-purple-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            
            <div class="relative">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform shadow-lg">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2">
                    Browse Events
                </h3>
                <p class="text-gray-400 mb-4">Discover concerts and shows near you</p>
                
                <div class="flex items-center text-purple-400 font-semibold group-hover:translate-x-2 transition-transform">
                    Explore <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

        {{-- My Bookings --}}
        <a href="{{ route('bookings.index') }}" class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-blue-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            
            <div class="relative">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2">
                    My Bookings
                </h3>
                <p class="text-gray-400 mb-4">View and manage your ticket reservations</p>
                
                <div class="flex items-center text-blue-400 font-semibold group-hover:translate-x-2 transition-transform">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

        {{-- Favorites --}}
        <a href="{{ route('favorites.index') }}" class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:border-pink-500/50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-pink-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            
            <div class="relative">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform shadow-lg">
                    <i class="fas fa-heart text-white text-xl"></i>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2">
                    Favorites
                </h3>
                <p class="text-gray-400 mb-4">Your saved events and wishlists</p>
                
                <div class="flex items-center text-pink-400 font-semibold group-hover:translate-x-2 transition-transform">
                    Open <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

    </div>

    {{-- Recent Bookings Section --}}
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-3xl border border-white/10 overflow-hidden">
        <div class="p-8 border-b border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Recent Bookings</h2>
                    <p class="text-gray-400">Your latest ticket reservations</p>
                </div>
                <a href="{{ route('bookings.index') }}" class="hidden md:flex items-center gap-2 text-purple-400 hover:text-purple-300 font-semibold group transition">
                    View All 
                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
        </div>

        @php
            $recentBookings = auth()->user()->bookings()->with('event')->latest()->take(5)->get();
        @endphp

        @if($recentBookings->count() > 0)
        <div class="divide-y divide-white/10">
            @foreach($recentBookings as $booking)
            <div class="p-6 hover:bg-white/5 transition group">
                <div class="flex items-center gap-6">
                    <!-- Event Image -->
                    <div class="flex-shrink-0">
                        @if($booking->event->image_url)
                        <img src="{{ asset('storage/' . $booking->event->image_url) }}" 
                             alt="{{ $booking->event->title }}" 
                             class="w-24 h-24 object-cover rounded-2xl group-hover:scale-105 transition">
                        @else
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center group-hover:scale-105 transition">
                            <i class="fas fa-music text-white text-2xl"></i>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Booking Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-white text-lg mb-1 truncate">{{ $booking->event->title }}</h3>
                        <div class="flex flex-wrap gap-3 text-sm text-gray-400 mb-2">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-ticket-alt text-purple-400"></i>
                                {{ $booking->quantity }} ticket(s)
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-money-bill-wave text-green-400"></i>
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">Booked {{ $booking->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex-shrink-0">
                        @if(strtolower($booking->status) === 'pending')
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/30 text-yellow-300 rounded-full font-semibold">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                            Pending
                        </span>
                        @elseif(strtolower($booking->status) === 'approved')
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-green-500/20 backdrop-blur-sm border border-green-500/30 text-green-300 rounded-full font-semibold">
                            <i class="fas fa-check-circle"></i>
                            Approved
                        </span>
                        @elseif(strtolower($booking->status) === 'rejected')
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-red-500/20 backdrop-blur-sm border border-red-500/30 text-red-300 rounded-full font-semibold">
                            <i class="fas fa-times-circle"></i>
                            Rejected
                        </span>
                        @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-gray-500/20 backdrop-blur-sm border border-gray-500/30 text-gray-300 rounded-full font-semibold">
                            {{ ucfirst($booking->status) }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-20 text-center">
            <div class="w-32 h-32 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-ticket-alt text-gray-500 text-5xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">No Bookings Yet</h3>
            <p class="text-gray-400 text-lg mb-8 max-w-md mx-auto">
                Start your concert journey! Explore amazing events and book your first ticket today.
            </p>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full font-bold hover:shadow-xl hover:shadow-purple-500/50 hover:scale-105 transition">
                <i class="fas fa-search"></i>
                Discover Events
            </a>
        </div>
        @endif
    </div>

</div>
@endsection