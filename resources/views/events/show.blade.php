<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - seeUoNstage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600">
                    <i class="fas fa-music mr-2"></i>seeUoNstage
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-purple-600">
                        Events
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Register
                        </a>
                    @else
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-purple-600">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Event Image -->
    <div class="relative h-96 bg-gradient-to-r from-purple-600 to-pink-600 overflow-hidden">
        @if($event->image_url)
            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover opacity-80">
        @else
            <div class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                <i class="fas fa-image text-white text-6xl opacity-30"></i>
            </div>
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        
        <!-- Back Button -->
        <a href="{{ route('events.index') }}" class="absolute top-6 left-6 bg-white text-gray-800 p-2 rounded-full hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- Favorite Button -->
        <div class="absolute top-6 right-6">
            @auth
                <form action="{{ route('favorites.toggle', $event) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-white text-red-600 p-3 rounded-full hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-heart{{ $isFavorited ? '' : ' far' }}"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white text-red-600 p-3 rounded-full hover:bg-gray-100 transition shadow-lg inline-block">
                    <i class="far fa-heart"></i>
                </a>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-3 gap-8">
            <!-- Left Column - Event Info -->
            <div class="col-span-2">
                <!-- Event Header -->
                <div class="mb-8">
                    @if($event->category)
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full mb-4">
                            {{ $event->category }}
                        </span>
                    @endif
                    
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                    
                    @if($event->artist)
                        <p class="text-xl text-gray-600">
                            <i class="fas fa-user-circle mr-2 text-purple-600"></i>{{ $event->artist }}
                        </p>
                    @endif
                </div>

                <!-- Event Meta Info -->
                <div class="bg-white rounded-lg shadow p-6 mb-8 space-y-4">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl mt-1 w-6"></i>
                        <div>
                            <p class="text-sm text-gray-500">Date & Time</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $event->start_datetime->format('l, F d, Y') }}
                            </p>
                            <p class="text-gray-600">
                                {{ $event->start_datetime->format('h:i A') }} - {{ $event->end_datetime->format('h:i A') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <i class="fas fa-map-marker-alt text-red-600 text-xl mt-1 w-6"></i>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $event->location }}</p>
                        </div>
                    </div>

                    @if($event->organizer)
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-user-tie text-green-600 text-xl mt-1 w-6"></i>
                            <div>
                                <p class="text-sm text-gray-500">Organizer</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $event->organizer->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Event</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                </div>
            </div>

            <!-- Right Column - Ticket Booking -->
            <div class="col-span-1">
                <!-- Ticket Section -->
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Get Tickets</h2>

                    @if($event->ticketTypes->count() > 0)
                        <div class="space-y-4 mb-6">
                            @foreach($event->ticketTypes as $ticketType)
                                <div class="border rounded-lg p-4 hover:border-purple-600 transition cursor-pointer ticket-option" data-ticket-id="{{ $ticketType->id }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-900">{{ $ticketType->name }}</h3>
                                        <span class="text-lg font-bold text-purple-600">
                                            Rp {{ number_format($ticketType->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    @if($ticketType->description)
                                        <p class="text-sm text-gray-600 mb-2">{{ $ticketType->description }}</p>
                                    @endif

                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">
                                            <i class="fas fa-ticket-alt mr-1"></i>
                                            @if($ticketType->quota > 0)
                                                {{ $ticketType->quota }} available
                                            @else
                                                <span class="text-red-600 font-semibold">Sold Out</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Book Button -->
                        @auth
                            @if(auth()->user()->role === 'user')
                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="ticket_type_id" id="selected_ticket_type" value="">
                                    
                                    <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition" id="bookButton" disabled>
                                        <i class="fas fa-shopping-cart mr-2"></i>Book Tickets
                                    </button>
                                </form>
                            @else
                                <div class="w-full px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold text-center cursor-not-allowed">
                                    Only users can book tickets
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition text-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login to Book
                            </a>
                        @endauth
                    @else
                        <div class="bg-gray-100 rounded-lg p-6 text-center">
                            <i class="fas fa-ticket-alt text-gray-400 text-3xl mb-3 block"></i>
                            <p class="text-gray-600 font-medium">No tickets available for this event</p>
                        </div>
                    @endif

                    <!-- Event Status Badge -->
                    <div class="mt-6 pt-6 border-t">
                        @if($event->is_published)
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Published
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                <i class="fas fa-eye-slash mr-1"></i>Coming Soon
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ticket selection
        const ticketOptions = document.querySelectorAll('.ticket-option');
        const selectedTicketInput = document.getElementById('selected_ticket_type');
        const bookButton = document.getElementById('bookButton');

        ticketOptions.forEach(option => {
            option.addEventListener('click', function() {
                ticketOptions.forEach(opt => opt.classList.remove('border-purple-600', 'bg-purple-50'));
                this.classList.add('border-purple-600', 'bg-purple-50');
                selectedTicketInput.value = this.dataset.ticketId;
                
                // Enable book button if a ticket is selected and has quota
                const quota = this.querySelector('.text-sm').textContent;
                if (!quota.includes('Sold Out') && bookButton) {
                    bookButton.disabled = false;
                }
            });
        });
    </script>
</body>
</html>