@extends('layouts.user')

@section('title', 'Favorite Events')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Favorite Events</h1>
            <p class="text-gray-400 mt-1">Your saved concerts and events</p>
        </div>
        <a href="{{ route('events.index') }}" class="bg-white text-gray-900 px-6 py-3 rounded-full font-bold hover:bg-gray-100 transition">
            <i class="fas fa-search mr-2"></i>Discover More
        </a>
    </div>

    {{-- Favorites Grid --}}
    @php
        $favorites = auth()->user()->favorites()->with('ticketTypes')->latest('favorites.created_at')->get();
    @endphp

    @if($favorites->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $event)
        <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden hover:border-pink-500/50 hover:shadow-2xl transition group">
            
            {{-- Event Image --}}
            <div class="relative h-48 overflow-hidden">
                @if($event->image_url)
                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
                @else
                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <i class="fas fa-music text-white text-5xl opacity-50"></i>
                </div>
                @endif

                {{-- Remove from Favorites Button --}}
                <form action="{{ route('favorites.toggle', $event) }}" method="POST" class="absolute top-3 right-3">
                    @csrf
                    <button type="submit" class="bg-white/10 backdrop-blur-md hover:bg-white/20 text-red-400 p-2 rounded-full border border-white/20 shadow-lg transition">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>

                {{-- Category Badge --}}
                @if($event->category)
                <span class="absolute top-3 left-3 px-3 py-1 bg-white/10 backdrop-blur-md text-white border border-white/20 text-xs font-semibold rounded-full">
                    {{ $event->category }}
                </span>
                @endif
            </div>

            {{-- Event Info --}}
            <div class="p-5">
                <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $event->title }}</h3>
                
                @if($event->artist)
                <p class="text-purple-400 font-medium mb-3">{{ $event->artist }}</p>
                @endif

                <div class="space-y-2 text-sm text-gray-400 mb-4">
                    <p class="flex items-center">
                        <i class="fas fa-calendar w-5 text-blue-400"></i>
                        {{ $event->start_datetime->format('M d, Y') }}
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-clock w-5 text-green-400"></i>
                        {{ $event->start_datetime->format('h:i A') }}
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5 text-red-400"></i>
                        {{ Str::limit($event->location, 30) }}
                    </p>
                </div>

                {{-- Price Range --}}
                @if($event->ticketTypes->count() > 0)
                <div class="mb-4 pb-4 border-b border-white/10">
                    <p class="text-sm text-gray-400">Starting from</p>
                    <p class="text-2xl font-bold text-purple-400">
                        Rp {{ number_format($event->ticketTypes->min('price'), 0, ',', '.') }}
                    </p>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex space-x-2">
                    <a href="{{ route('events.show', $event) }}" class="flex-1 bg-white text-gray-900 text-center py-2 px-4 rounded-full font-bold hover:bg-gray-100 transition">
                        <i class="fas fa-ticket-alt mr-2"></i>Book Now
                    </a>
                    <a href="{{ route('events.show', $event) }}" class="bg-white/10 hover:bg-white/20 border border-white/10 text-white py-2 px-4 rounded-full transition">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Stats Section --}}
    <div class="relative rounded-xl overflow-hidden" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,.03) 2px, rgba(255,255,255,.03) 4px), linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
        <div class="p-8 text-white relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">{{ $favorites->count() }} Favorite Events</h3>
                    <p class="text-purple-100">You have {{ $favorites->count() }} {{ Str::plural('concert', $favorites->count()) }} saved in your favorites</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-heart text-6xl opacity-20"></i>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- Empty State --}}
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl p-12 text-center">
        <div class="w-32 h-32 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-heart text-red-400 text-5xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-white mb-3">No Favorite Events Yet</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            Start saving your favorite concerts and events! Click the heart icon on any event to add it to your favorites.
        </p>
        <a href="{{ route('events.index') }}" class="inline-block bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
            <i class="fas fa-search mr-2"></i>Discover Events
        </a>
    </div>
    @endif

</div>
@endsection