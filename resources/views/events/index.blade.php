<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
            background-image: 
                radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.1) 0px, transparent 50%);
        }
        
        .dot-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-900/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    seeUoNstage
                </a>
                <span class="text-gray-400 text-sm">Discover events</span>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white px-5 py-2 font-medium transition">Dashboard</a>
                    @elseif(auth()->user()->role === 'organizer')
                        <a href="{{ route('organizer.dashboard') }}" class="text-gray-300 hover:text-white px-5 py-2 font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-5 py-2 font-medium transition">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-gray-900 px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-5 py-2 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition">Sign up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="pt-24 pb-12 px-6 border-b border-white/10 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-pink-500/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to home
            </a>
            <h1 class="text-5xl font-bold mb-3">All Events</h1>
            <p class="text-gray-400 text-lg">Find your next unforgettable experience</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 relative">
        <!-- Background pattern -->
        <div class="absolute inset-0 grid-pattern opacity-50 pointer-events-none"></div>
        
        <div class="relative z-10">
        <!-- Search and Filters -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/5 p-6 mb-8 relative overflow-hidden">
            <!-- Subtle pattern overlay -->
            <div class="absolute inset-0 dot-pattern opacity-30 pointer-events-none"></div>
            
            <form method="GET" action="{{ route('events.index') }}" class="space-y-6 relative z-10">
                <!-- Main Search -->
                <div class="relative">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search events, artists, locations..." 
                        class="w-full bg-gray-900/50 text-white placeholder-gray-500 pl-12 pr-4 py-4 rounded-xl border border-white/10 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                </div>

                <!-- Filter Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Category</label>
                        <select name="category" class="w-full bg-gray-900/50 text-white px-4 py-3 rounded-xl border border-white/10 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                            <option value="">All</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Location</label>
                        <select name="location" class="w-full bg-gray-900/50 text-white px-4 py-3 rounded-xl border border-white/10 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                            <option value="">All</option>
                            @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Date</label>
                        <input 
                            type="date" 
                            name="date" 
                            value="{{ request('date') }}"
                            class="w-full bg-gray-900/50 text-white px-4 py-3 rounded-xl border border-white/10 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Sort</label>
                        <select name="sort" class="w-full bg-gray-900/50 text-white px-4 py-3 rounded-xl border border-white/10 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                    Apply Filters
                </button>

                <!-- Active Filters -->
                @if(request()->hasAny(['search', 'category', 'location', 'date', 'sort']))
                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <div class="flex flex-wrap gap-2">
                        @if(request('search'))
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                            {{ request('search') }}
                        </span>
                        @endif
                        @if(request('category'))
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                            {{ request('category') }}
                        </span>
                        @endif
                        @if(request('location'))
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                            {{ request('location') }}
                        </span>
                        @endif
                        @if(request('date'))
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">
                            {{ request('date') }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('events.index') }}" class="text-purple-400 hover:text-purple-300 font-medium">
                        Clear all
                    </a>
                </div>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-400">
                <span class="text-white font-semibold">{{ $events->total() }}</span> events found
            </p>
            @if($events->hasPages())
            <p class="text-gray-400 text-sm">
                Showing {{ $events->firstItem() }}-{{ $events->lastItem() }}
            </p>
            @endif
        </div>

        <!-- Events Grid -->
        @if($events->count() > 0)
        <!-- Decorative blob -->
        <div class="absolute left-1/4 top-1/2 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl -z-10"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($events as $event)
            <a href="{{ route('events.show', $event) }}" class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/5 hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-2">
                <!-- Image -->
                <div class="aspect-[16/10] overflow-hidden">
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500"></div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    @if($event->category)
                    <span class="inline-block px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-semibold mb-3">
                        {{ $event->category }}
                    </span>
                    @endif
                    
                    <h3 class="text-xl font-bold mb-2 group-hover:text-purple-300 transition">
                        {{ Str::limit($event->title, 40) }}
                    </h3>
                    
                    @if($event->artist)
                        <p class="text-gray-400 mb-4">{{ Str::limit($event->artist, 35) }}</p>
                    @endif
                    
                    <div class="space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $event->start_datetime->format('M d, Y • h:i A') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ Str::limit($event->location, 30) }}
                        </div>
                    </div>
                </div>
                
                <!-- Hover indicator -->
                <div class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="flex justify-center">
            {{ $events->links() }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-20 h-20 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold mb-2">No events found</h3>
            <p class="text-gray-400 mb-6">Try adjusting your filters or search term</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                Clear filters
            </a>
        </div>
        @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-white/10 py-12 px-6 mt-20">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-500">&copy; 2024 seeUoNstage. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>