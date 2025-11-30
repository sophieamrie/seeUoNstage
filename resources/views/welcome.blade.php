{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>seeUoNstage - Book Concert Tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { font-family: 'Space Grotesk', sans-serif; }
        
        .noise-bg {
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,.03) 2px, rgba(255,255,255,.03) 4px),
                linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .spotlight {
            position: relative;
            overflow: hidden;
        }
        
        .spotlight::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: spotlight 8s ease-in-out infinite;
        }
        
        @keyframes spotlight {
            0%, 100% { transform: translate(0, 0); }
            25% { transform: translate(20%, 20%); }
            50% { transform: translate(-10%, 30%); }
            75% { transform: translate(30%, -10%); }
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .bento-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }
        
        .category-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .category-hover:hover {
            transform: translateY(-8px) rotate(-2deg);
        }
    </style>
</head>
<body class="bg-gray-900 m-0 p-0">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-900/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    seeUoNstage
                </a>
                <a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white transition font-medium hidden md:block">
                    Events
                </a>
            </div>

            <div class="flex gap-3 items-center">
                @auth
                    <span class="text-gray-400 text-sm">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'organizer')
                        <a href="{{ route('organizer.dashboard') }}" class="text-gray-300 hover:text-white transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition">
                            Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-gray-900 px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-5 py-2 font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        Sign up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="noise-bg spotlight min-h-screen flex items-center justify-center pt-20 px-6 relative overflow-hidden">
        <!-- Floating elements -->
        <div class="absolute top-40 left-10 w-20 h-20 bg-pink-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <div class="inline-block mb-6 px-6 py-2 glass rounded-full text-purple-200 text-sm font-medium">
                ✨ Live concerts & festivals near you
            </div>
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-tight">
                Your stage<br/>awaits
            </h1>
            <p class="text-xl md:text-2xl text-purple-200 mb-12 max-w-2xl mx-auto">
                Discover unforgettable live experiences. From indie shows to major festivals.
            </p>

            <!-- Search Bar -->
            <div class="max-w-3xl mx-auto mb-16">
                <form action="{{ route('events.index') }}" method="GET" class="glass rounded-2xl p-2">
                    <div class="flex flex-col md:flex-row gap-2">
                        <input type="text" 
                               name="search" 
                               placeholder="Search artists, events..." 
                               class="flex-1 bg-white/10 text-white placeholder-purple-200 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition">
                        
                        <select name="category"
                            class="bg-white/10 text-white px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition appearance-none"
                        >
                            <option value="">All Types</option>
                            <option value="Concert" class="text-black">Concert</option>
                            <option value="Festival" class="text-black">Festival</option>
                            <option value="Theater" class="text-black">Theater</option>
                            <option value="Comedy" class="text-black">Comedy</option>
                        </select>

                        
                        <input type="text" 
                               name="location" 
                               placeholder="Location..." 
                               class="bg-white/10 text-white placeholder-purple-200 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition">
                        
                        <button type="submit" class="bg-white text-gray-900 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition whitespace-nowrap">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('events.index', ['category' => 'Concert']) }}" class="glass px-6 py-3 rounded-full text-white hover:bg-white/10 transition">
                    🎸 Concerts
                </a>
                <a href="{{ route('events.index', ['category' => 'Festival']) }}" class="glass px-6 py-3 rounded-full text-white hover:bg-white/10 transition">
                    🎪 Festivals
                </a>
                <a href="{{ route('events.index', ['category' => 'Theater']) }}" class="glass px-6 py-3 rounded-full text-white hover:bg-white/10 transition">
                    🎭 Theater
                </a>
                <a href="{{ route('events.index', ['category' => 'Comedy']) }}" class="glass px-6 py-3 rounded-full text-white hover:bg-white/10 transition">
                    😂 Comedy
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Events -->
    <section class="bg-gray-50 py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">What's New</span>
                    <h2 class="text-5xl font-bold text-gray-900 mt-2">Latest Events</h2>
                </div>
                <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold group">
                    See all 
                    <span class="inline-block transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>

            <div class="relative overflow-hidden">
                <div id="carousel" class="flex transition-transform duration-500 ease-out">
                    @php
                        $latestChunks = $latestEvents->chunk(2);
                        $totalSlides = $latestChunks->count();
                    @endphp

                    @forelse($latestChunks as $chunk)
                        <div class="min-w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($chunk as $event)
                                <a href="{{ route('events.show', $event) }}" class="group relative overflow-hidden rounded-3xl bg-gray-900 aspect-[4/3]">
                                    @if($event->image_url)
                                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                                             alt="{{ $event->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-pink-600"></div>
                                    @endif
                                    
                                    <div class="absolute bottom-0 left-0 right-0 p-8">
                                        <div class="flex gap-3 mb-4">
                                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs">
                                                {{ $event->start_datetime->format('M d') }}
                                            </span>
                                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs">
                                                {{ Str::limit($event->location, 20) }}
                                            </span>
                                        </div>
                                        <h3 class="text-3xl font-bold text-white mb-2 group-hover:text-purple-300 transition">
                                            {{ $event->title }}
                                        </h3>
                                        @if($event->artist)
                                            <p class="text-purple-200 text-lg">{{ $event->artist }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @empty
                        <div class="min-w-full grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="rounded-3xl bg-gradient-to-br from-purple-600 to-pink-600 aspect-[4/3] flex items-center justify-center p-8">
                                <div class="text-center text-white">
                                    <div class="text-6xl mb-4">🎵</div>
                                    <h3 class="text-2xl font-bold mb-2">Coming Soon</h3>
                                    <p class="text-purple-100">Exciting events are on the way</p>
                                </div>
                            </div>
                            <div class="rounded-3xl bg-gradient-to-br from-blue-600 to-cyan-600 aspect-[4/3] flex items-center justify-center p-8">
                                <div class="text-center text-white">
                                    <div class="text-6xl mb-4">🎤</div>
                                    <h3 class="text-2xl font-bold mb-2">Stay Tuned</h3>
                                    <p class="text-blue-100">Check back soon for updates</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($totalSlides > 1)
                    <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-100 text-gray-900 p-4 rounded-full shadow-xl transition z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    
                    <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-100 text-gray-900 p-4 rounded-full shadow-xl transition z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <div class="flex justify-center mt-8 gap-2">
                        @for($i = 0; $i < $totalSlides; $i++)
                            <button class="slide-indicator h-2 rounded-full transition-all {{ $i === 0 ? 'w-8 bg-purple-600' : 'w-2 bg-gray-300' }}" data-slide="{{ $i }}"></button>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- This Week's Lineup -->
    <section class="bg-gray-900 py-24 px-6 relative overflow-hidden">
        <!-- Decorative background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-purple-400 font-semibold text-sm uppercase tracking-wider">Next 7 Days</span>
                    <h2 class="text-5xl font-bold text-white mt-2">This Week's Lineup</h2>
                    <p class="text-gray-400 mt-3">Don't miss these upcoming shows</p>
                </div>
                <a href="{{ route('events.index') }}" class="text-purple-400 hover:text-purple-300 font-semibold group hidden md:flex items-center gap-2">
                    View calendar 
                    <span class="inline-block transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($thisWeekEvents as $event)
                    <a href="{{ route('events.show', $event) }}" class="group relative bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden border border-white/5 hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-2">
                        <div class="aspect-[16/10] overflow-hidden">
                            @if($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" 
                                     alt="{{ $event->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500"></div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <!-- Date Badge -->
                            <div class="inline-flex items-center gap-2 mb-4 px-3 py-1.5 bg-purple-500/20 rounded-full">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-purple-300 text-sm font-semibold">
                                    {{ $event->start_datetime->format('D, M j') }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-300 transition">
                                {{ Str::limit($event->title, 35) }}
                            </h3>
                            
                            @if($event->artist)
                                <p class="text-gray-400 mb-3">{{ Str::limit($event->artist, 30) }}</p>
                            @endif
                            
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ Str::limit($event->location, 25) }}
                            </div>
                        </div>
                        
                        <!-- Hover indicator -->
                        <div class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-16">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No events this week</h3>
                        <p class="text-gray-500">Check back soon for upcoming shows</p>
                    </div>
                @endforelse
            </div>
            
            @if($thisWeekEvents->count() > 0)
                <div class="text-center mt-12">
                    <a href="{{ route('events.index') }}" class="inline-block text-purple-400 hover:text-purple-300 font-semibold">
                        See full calendar →
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-gray-50 py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Don't miss out
            </h2>
            <p class="text-xl text-gray-600 mb-10">
                Thousands of live events happening every month. Find yours today.
            </p>
            <a href="{{ route('events.index') }}" class="inline-block bg-gray-900 text-white px-10 py-5 rounded-full font-semibold text-lg hover:bg-gray-800 transition transform hover:scale-105">
                Explore all events
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-white/10 py-12 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-500">&copy; 2024 seeUoNstage. All rights reserved.</p>
        </div>
    </footer>

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
                        indicator.classList.remove('w-2', 'bg-gray-300');
                        indicator.classList.add('w-8', 'bg-purple-600');
                    } else {
                        indicator.classList.remove('w-8', 'bg-purple-600');
                        indicator.classList.add('w-2', 'bg-gray-300');
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

</body>
</html>