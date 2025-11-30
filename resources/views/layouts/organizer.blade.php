<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
            background-image: 
                radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.08) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.08) 0px, transparent 50%);
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800/50 backdrop-blur-sm border-r border-white/10 flex flex-col">
            
            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    seeUoNstage
                </h2>
                <p class="text-xs text-gray-400 mt-1">Organizer Panel</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('organizer.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->is('organizer/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('organizer.events.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->is('organizer/events*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span class="ml-3 font-medium">My Events</span>
                </a>

                <a href="{{ route('organizer.bookings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->is('organizer/bookings*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span class="ml-3 font-medium">Bookings</span>
                </a>

                <div class="h-px bg-white/10 my-4"></div>

                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl transition text-gray-400 hover:text-white hover:bg-white/5 group">
                    <i class="fas fa-arrow-left w-5"></i>
                    <span class="ml-3 font-medium">Back to Website</span>
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-white/10">
                <div class="glass rounded-xl p-4 mb-3 border border-white/10">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full glass hover:bg-white/10 text-white py-2.5 px-4 rounded-xl font-medium transition flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="glass sticky top-0 z-10 px-8 py-4 border-b border-white/10">
                <h1 class="text-2xl font-bold text-white">@yield('title')</h1>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Success Messages -->
                @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm rounded-xl px-4 py-3 mb-6 flex items-center text-green-300">
                    <i class="fas fa-check-circle mr-3 text-green-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <!-- Error Messages -->
                @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm rounded-xl px-4 py-3 mb-6 flex items-center text-red-300">
                    <i class="fas fa-exclamation-circle mr-3 text-red-400"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>