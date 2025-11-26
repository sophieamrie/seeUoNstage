<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>seeUoNstage - Book Concert Tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 m-0 p-0">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <!-- Left: Brand & Nav -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600">seeUoNstage</a>
            <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-purple-600 font-semibold transition">Browse Events</a>
        </div>

        <!-- Right: Login & Register -->
        <div class="flex space-x-4">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Admin Dashboard
                    </a>
                @elseif(auth()->user()->role === 'organizer')
                    <a href="{{ route('organizer.dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Organizer Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        My Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-50 text-purple-600 border-2 border-purple-600 px-6 py-2 rounded-lg font-semibold transition">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section with CTA -->
    <section class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-12 px-8">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Discover Amazing Events</h1>
            <p class="text-xl mb-8 text-purple-100">Find and book tickets to concerts, festivals, and shows near you</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-white text-purple-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-purple-50 transition transform hover:scale-105 shadow-lg">
                <i class="fas fa-compass mr-2"></i>Browse All Events
            </a>
        </div>
    </section>

    <!-- Main Content Area - Sliding Carousel -->
    <section class="p-8 relative" id="events">
        <!-- Section Header -->
        <div class="max-w-6xl mx-auto mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Latest Events</h2>
                <p class="text-gray-600">Check out the newest additions to our lineup</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="relative overflow-hidden max-w-6xl mx-auto">
            <!-- Carousel Container -->
            <div id="carousel" class="flex transition-transform duration-500 ease-in-out">
                
                @php
                    // Group latest events into pairs for slides
                    $latestChunks = $latestEvents->chunk(2);
                    $totalSlides = $latestChunks->count();
                @endphp

                @forelse($latestChunks as $chunk)
                <!-- Slide -->
                <div class="min-w-full grid grid-cols-2 gap-8 h-96">
                    @foreach($chunk as $event)
                    <a href="{{ route('events.show', $event) }}" class="bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl shadow-xl overflow-hidden group hover:scale-105 transition-transform duration-300">
                        @if($event->image_url)
                        <div class="h-full w-full relative">
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                                <h2 class="text-3xl font-bold mb-2">{{ $event->title }}</h2>
                                @if($event->artist)
                                <p class="text-xl mb-2 text-purple-200">{{ $event->artist }}</p>
                                @endif
                                <div class="flex items-center text-sm space-x-4">
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $event->start_datetime->format('M d, Y') }}</span>
                                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ Str::limit($event->location, 20) }}</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="h-full flex items-center justify-center p-8">
                            <div class="text-center text-white">
                                <h2 class="text-4xl font-bold mb-4">{{ $event->title }}</h2>
                                @if($event->artist)
                                <p class="text-2xl mb-4 text-purple-100">{{ $event->artist }}</p>
                                @endif
                                <div class="flex flex-col items-center space-y-2 text-lg">
                                    <span><i class="fas fa-calendar mr-2"></i>{{ $event->start_datetime->format('M d, Y') }}</span>
                                    <span><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </a>
                    @endforeach
                </div>
                @empty
                <!-- Empty State Slide -->
                <div class="min-w-full grid grid-cols-2 gap-8 h-96">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white p-8">
                            <i class="fas fa-calendar-alt text-6xl mb-4 opacity-50"></i>
                            <h2 class="text-3xl font-bold mb-2">No Events Yet</h2>
                            <p class="text-xl">Check back soon for upcoming concerts!</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-400 to-cyan-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white p-8">
                            <i class="fas fa-music text-6xl mb-4 opacity-50"></i>
                            <h2 class="text-3xl font-bold mb-2">Coming Soon</h2>
                            <p class="text-xl">Exciting events are on the way!</p>
                        </div>
                    </div>
                </div>
                @endforelse

            </div>

            @if($totalSlides > 1)
            <!-- Navigation Arrows -->
            <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-purple-600 p-4 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-purple-600 p-4 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Slide Indicators -->
            <div class="flex justify-center mt-6 space-x-2">
                @for($i = 0; $i < $totalSlides; $i++)
                <button class="slide-indicator w-3 h-3 rounded-full {{ $i === 0 ? 'bg-purple-600' : 'bg-gray-300' }}" data-slide="{{ $i }}"></button>
                @endfor
            </div>
            @endif
        </div>
    </section>

    <script>
        const totalSlides = {{ $totalSlides }};
        
        if (totalSlides > 1) {
            let currentSlide = 0;
            const carousel = document.getElementById('carousel');
            const indicators = document.querySelectorAll('.slide-indicator');

            function updateCarousel() {
                carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.remove('bg-gray-300');
                        indicator.classList.add('bg-purple-600');
                    } else {
                        indicator.classList.remove('bg-purple-600');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }

            document.getElementById('prevBtn').addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            });

            document.getElementById('nextBtn').addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            });

            indicators.forEach((indicator) => {
                indicator.addEventListener('click', () => {
                    currentSlide = parseInt(indicator.dataset.slide);
                    updateCarousel();
                });
            });

            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateCarousel();
                }
                if (touchEndX > touchStartX + 50) {
                    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }
            }
        }
    </script>

    <!-- Popular Events Section -->
    <section class="bg-gradient-to-b from-purple-900 to-indigo-900 text-white px-12 py-12">
        
        <!-- Section Header -->
        <div class="max-w-6xl mx-auto mb-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Popular Events</h2>
                    <p class="text-purple-200">Trending events you don't want to miss</p>
                </div>
                <a href="{{ route('events.index') }}" class="text-white hover:text-purple-200 font-semibold flex items-center">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Popular Events Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @forelse($popularEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="group">
                    @if($event->image_url)
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-3 mx-auto border-4 border-white/20 group-hover:border-white/50 transition group-hover:scale-110 duration-300 shadow-lg">
                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-3xl font-bold mb-3 mx-auto border-4 border-white/20 group-hover:border-white/50 group-hover:scale-110 transition duration-300 shadow-lg">
                        {{ substr($event->title, 0, 1) }}
                    </div>
                    @endif
                    <p class="text-center text-sm font-semibold group-hover:text-purple-200 transition">{{ Str::limit($event->title, 20) }}</p>
                    @if($event->artist)
                    <p class="text-center text-xs text-purple-300">{{ Str::limit($event->artist, 15) }}</p>
                    @endif
                </a>
                @empty
                <div class="col-span-6 text-center py-8">
                    <i class="fas fa-music text-4xl opacity-50 mb-4"></i>
                    <p class="text-purple-200">No popular events yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-white py-16 px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Ready to Find Your Next Event?</h2>
            <p class="text-xl text-gray-600 mb-8">Browse our full catalog of concerts, festivals, and shows</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-10 py-4 rounded-full font-bold text-lg hover:shadow-xl transition transform hover:scale-105">
                <i class="fas fa-ticket-alt mr-2"></i>Explore All Events
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 px-12">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-gray-400">&copy; 2024 seeUoNstage. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>