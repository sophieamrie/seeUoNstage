<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events - seeUoNstage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">seeUoNstage</h1>
                    <span class="text-sm text-gray-600">event</span>
                </a>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-purple-600">Dashboard</a>
                        @elseif(auth()->user()->role === 'organizer')
                            <a href="{{ route('organizer.dashboard') }}" class="text-gray-700 hover:text-purple-600">Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 border-2 border-purple-600 text-purple-600 rounded-full hover:bg-purple-50 transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-bold mb-2">Browse All Events</h1>
            <p class="text-purple-100">Discover amazing events happening around you</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('events.index') }}" class="space-y-4">
                <!-- Search Bar -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search events, artists, or locations..." 
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <button type="submit" class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>

                <!-- Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <select name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input 
                            type="date" 
                            name="date" 
                            value="{{ request('date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <!-- Sort Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters & Clear Button -->
                @if(request()->hasAny(['search', 'category', 'location', 'date', 'sort']))
                <div class="flex items-center justify-between pt-4 border-t">
                    <div class="flex flex-wrap gap-2">
                        @if(request('search'))
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                            Search: {{ request('search') }}
                        </span>
                        @endif
                        @if(request('category'))
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                            Category: {{ request('category') }}
                        </span>
                        @endif
                        @if(request('location'))
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                            Location: {{ request('location') }}
                        </span>
                        @endif
                        @if(request('date'))
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                            Date: {{ request('date') }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                        <i class="fas fa-times-circle mr-1"></i>Clear Filters
                    </a>
                </div>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing <span class="font-semibold">{{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }}</span> of <span class="font-semibold">{{ $events->total() }}</span> events
            </p>
        </div>

        <!-- Events Grid -->
        @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($events as $event)
            <a href="{{ route('events.show', $event) }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <!-- Event Image -->
                <div class="relative h-48 overflow-hidden">
                    @if($event->image_url)
                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                    @endif
                    @if($event->category)
                    <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-purple-600 rounded-full text-xs font-semibold">
                        {{ $event->category }}
                    </span>
                    @endif
                </div>

                <!-- Event Details -->
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition">
                        {{ $event->title }}
                    </h3>
                    
                    @if($event->artist)
                    <p class="text-sm text-purple-600 mb-3 font-medium">
                        <i class="fas fa-music mr-1"></i>{{ $event->artist }}
                    </p>
                    @endif

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-5 text-purple-500"></i>
                            <span>{{ $event->start_datetime->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock w-5 text-purple-500"></i>
                            <span>{{ $event->start_datetime->format('h:i A') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt w-5 text-purple-500"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            By {{ $event->organizer->name ?? 'N/A' }}
                        </span>
                        <span class="text-purple-600 font-semibold group-hover:translate-x-1 transition-transform">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $events->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calendar-times text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Events Found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your search or filters to find what you're looking for</p>
            <a href="{{ route('events.index') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-redo mr-2"></i>Clear All Filters
            </a>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400">&copy; 2024 seeUoNstage. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>