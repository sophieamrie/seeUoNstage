<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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
                <a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white transition font-medium">Events</a>
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

    <!-- Hero Image -->
    <div class="relative h-[60vh] overflow-hidden bg-gray-900">
        @if($event->image_url)
            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
        @endif
        
        <!-- Back & Favorite Buttons -->
        <div class="absolute top-24 left-0 right-0 px-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('events.index') }}" class="glass hover:bg-white/10 text-white px-4 py-2 rounded-full transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>

                @auth
                    @if(auth()->user()->role === 'user')
                        @php
                            $isFavorited = auth()->user()->favorites()->where('event_id', $event->id)->exists();
                        @endphp
                        <form action="{{ route('favorites.toggle', $event) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="glass hover:bg-white/10 text-white w-12 h-12 rounded-full transition flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $isFavorited ? 'fill-red-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Event Title Overlay -->
        <div class="absolute bottom-0 left-0 right-0 px-6 pb-12">
            <div class="max-w-7xl mx-auto">
                @if($event->category)
                <span class="inline-block px-4 py-1.5 glass text-white rounded-full text-sm font-semibold mb-4">
                    {{ $event->category }}
                </span>
                @endif
                <h1 class="text-5xl md:text-6xl font-bold mb-3 text-white">{{ $event->title }}</h1>
                @if($event->artist)
                    <p class="text-2xl text-purple-300">{{ $event->artist }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-12 relative">
        <!-- Background decorations -->
        <div class="absolute top-20 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-20 left-0 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl -z-10"></div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative z-10">
            <!-- Left Column - Event Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-6 hover:border-purple-500/50 transition">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Date & Time</p>
                                <p class="font-semibold text-white">{{ $event->start_datetime->format('F d, Y') }}</p>
                                <p class="text-sm text-gray-400">
                                    {{ $event->start_datetime->format('h:i A') }}
                                    @if($event->end_datetime)
                                        - {{ $event->end_datetime->format('h:i A') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-6 hover:border-pink-500/50 transition">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Location</p>
                                <p class="font-semibold text-white">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($event->organizer)
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-6 hover:border-green-500/50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Organized by</p>
                            <p class="font-semibold text-lg text-white">{{ $event->organizer->name }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-8">
                    <h2 class="text-2xl font-bold mb-4 text-white">About this event</h2>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                </div>
            </div>

            <!-- Right Column - Booking -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6 text-white">Get your tickets</h2>

                    @if($event->ticketTypes->count() > 0)
                        <div class="space-y-3 mb-6">
                            @foreach($event->ticketTypes as $ticketType)
                                @php
                                    $availableTickets = $ticketType->quota - $ticketType->sold;
                                    $isSoldOut = $availableTickets <= 0;
                                @endphp
                                <div class="border border-white/10 rounded-xl p-4 hover:border-purple-500/50 transition cursor-pointer ticket-option {{ $isSoldOut ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                     data-ticket-id="{{ $ticketType->id }}"
                                     data-sold-out="{{ $isSoldOut ? 'true' : 'false' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-lg text-white">{{ $ticketType->name }}</h3>
                                        <span class="text-xl font-bold text-purple-400">
                                            Rp{{ number_format($ticketType->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    @if($ticketType->description)
                                        <p class="text-sm text-gray-400 mb-3">{{ $ticketType->description }}</p>
                                    @endif

                                    @if($isSoldOut)
                                        <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-semibold">
                                            Sold Out
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold">
                                            {{ $availableTickets }} available
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Book Button -->
                        @auth
                            @if(auth()->user()->role === 'user')
                                <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="ticket_type_id" id="selected_ticket_type" value="">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <button type="submit" class="w-full bg-white text-gray-900 py-4 rounded-xl font-bold hover:bg-gray-100 transition disabled:bg-gray-700 disabled:text-gray-500 disabled:cursor-not-allowed" id="bookButton" disabled>
                                        Book Now
                                    </button>
                                </form>
                            @else
                                <div class="w-full py-4 bg-gray-700 text-gray-400 rounded-xl font-bold text-center cursor-not-allowed">
                                    Only users can book
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-white text-gray-900 py-4 rounded-xl font-bold hover:bg-gray-100 transition text-center">
                                Login to book
                            </a>
                        @endauth
                    @else
                        <div class="bg-gray-800 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <p class="text-gray-400">No tickets available yet</p>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    @if($event->is_published)
                        <div class="mt-6 pt-6 border-t border-white/10 text-center">
                            <span class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Event Live
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-white/10 py-12 px-6 mt-20">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-500">&copy; 2024 seeUoNstage. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const ticketOptions = document.querySelectorAll('.ticket-option');
        const selectedTicketInput = document.getElementById('selected_ticket_type');
        const bookButton = document.getElementById('bookButton');

        ticketOptions.forEach(option => {
            option.addEventListener('click', function() {
                if (this.dataset.soldOut === 'true') {
                    return;
                }

                ticketOptions.forEach(opt => {
                    opt.classList.remove('border-purple-500', 'bg-purple-500/10');
                });

                this.classList.add('border-purple-500', 'bg-purple-500/10');
                selectedTicketInput.value = this.dataset.ticketId;
                
                if (bookButton) {
                    bookButton.disabled = false;
                }
            });
        });
    </script>
</body>
</html>