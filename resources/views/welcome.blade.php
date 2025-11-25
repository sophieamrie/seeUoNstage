<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>seeUoNstage - Book Concert Tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 m-0 p-0">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
        <!-- Left: Brand & Nav -->
        <div class="flex items-center space-x-6">
            <h1 class="text-2xl font-bold text-purple-600">seeUoNstage</h1>
            <a href="#" class="text-gray-600 hover:text-purple-600 font-semibold transition">event</a>
        </div>

        <!-- Right: Login & Register -->
        <div class="flex space-x-4">
            <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-white hover:bg-gray-50 text-purple-600 border-2 border-purple-600 px-6 py-2 rounded-lg font-semibold transition">
                Register
            </a>
        </div>
    </nav>

    <!-- Main Content Area - Sliding Carousel -->
    <section class="p-8 relative">
        <div class="relative overflow-hidden">
            <!-- Carousel Container -->
            <div id="carousel" class="flex transition-transform duration-500 ease-in-out">
                
                <!-- Slide 1 -->
                <div class="min-w-full grid grid-cols-2 gap-8 h-96">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 1</h2>
                            <p class="text-xl">Featured Concert</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-400 to-cyan-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 2</h2>
                            <p class="text-xl">Popular Show</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="min-w-full grid grid-cols-2 gap-8 h-96">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 3</h2>
                            <p class="text-xl">Live Performance</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-400 to-red-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 4</h2>
                            <p class="text-xl">Music Festival</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="min-w-full grid grid-cols-2 gap-8 h-96">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 5</h2>
                            <p class="text-xl">Rock Concert</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-pink-400 to-purple-400 rounded-2xl shadow-xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <h2 class="text-4xl font-bold mb-4">Event 6</h2>
                            <p class="text-xl">Jazz Night</p>
                        </div>
                    </div>
                </div>

            </div>

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
        </div>

        <!-- Slide Indicators -->
        <div class="flex justify-center mt-6 space-x-2">
            <button class="slide-indicator w-3 h-3 rounded-full bg-purple-600" data-slide="0"></button>
            <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300" data-slide="1"></button>
            <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300" data-slide="2"></button>
        </div>
    </section>

    <script>
        let currentSlide = 0;
        const carousel = document.getElementById('carousel');
        const totalSlides = 3;
        const indicators = document.querySelectorAll('.slide-indicator');

        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
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

        // Click on indicators
        indicators.forEach((indicator) => {
            indicator.addEventListener('click', () => {
                currentSlide = parseInt(indicator.dataset.slide);
                updateCarousel();
            });
        });

        // Touch/Swipe support
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
                // Swipe left - next slide
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }
            if (touchEndX > touchStartX + 50) {
                // Swipe right - previous slide
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
        }
    </script>

    <!-- Bottom Slider Section - Featured Artists -->
    <section class="bg-gradient-to-b from-purple-900 to-indigo-900 text-white px-12 py-8">
        
        <!-- Top Row: Title and Search/Country -->
        <div class="flex items-center justify-between mb-8">
            <!-- Title -->
            <h2 class="text-xl font-semibold">Featured Artists</h2>

            <!-- Search & Country Filters -->
            <div class="flex space-x-3">
                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="Search..." class="bg-white/10 border border-white/20 text-white text-sm placeholder-white/50 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/30 w-48">
                    <svg class="w-4 h-4 absolute right-3 top-1/2 transform -translate-y-1/2 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Country Dropdown -->
                <select class="bg-white/10 border border-white/20 text-white text-sm px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/30 cursor-pointer">
                    <option value="">Country</option>
                    <option value="id">Indonesia</option>
                    <option value="us">United States</option>
                    <option value="uk">United Kingdom</option>
                    <option value="sg">Singapore</option>
                </select>
            </div>
        </div>

        <!-- Bottom Row: Artist Circles Left-aligned -->
        <div class="flex space-x-6">
            <!-- Artist A -->
            <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-xl font-bold cursor-pointer hover:scale-105 transition">
                A
            </div>

            <!-- Artist B -->
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-xl font-bold cursor-pointer hover:scale-105 transition">
                B
            </div>

            <!-- Artist C -->
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-xl font-bold cursor-pointer hover:scale-105 transition">
                C
            </div>

            <!-- Artist D -->
            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-xl font-bold cursor-pointer hover:scale-105 transition">
                D
            </div>

            <!-- Artist E -->
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center text-xl font-bold cursor-pointer hover:scale-105 transition">
                E
            </div>
        </div>

    </section>

</body>
</html>