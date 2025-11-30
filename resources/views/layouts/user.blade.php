<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>

<body class="bg-gray-900">

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 border-r border-white/10 flex flex-col">
            
            {{-- Logo --}}
            <div class="p-6 border-b border-white/10">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    seeUoNstage
                </h2>
                <p class="text-xs text-gray-500 mt-1">User Dashboard</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->is('dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->is('bookings*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span class="ml-3 font-medium">My Bookings</span>
                </a>

                <a href="{{ route('favorites.index') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->is('favorites*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-heart w-5"></i>
                    <span class="ml-3 font-medium">Favorites</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->is('profile*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-user w-5"></i>
                    <span class="ml-3 font-medium">Profile</span>
                </a>

                <div class="h-px bg-white/10 my-4"></div>

                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl transition text-gray-400 hover:text-white hover:bg-white/5">
                    <i class="fas fa-arrow-left w-5"></i>
                    <span class="ml-3 font-medium">Back to Website</span>
                </a>
            </nav>

            {{-- User Info & Logout --}}
            <div class="p-4 border-t border-white/10">
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 mb-3 border border-white/10">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white/10 hover:bg-white/20 text-white py-2.5 px-4 rounded-xl font-medium transition flex items-center justify-center border border-white/10">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto bg-gray-900">
            {{-- Top Bar --}}
            <header class="bg-gray-800/50 backdrop-blur-sm border-b border-white/10 px-8 py-4 sticky top-0 z-10">
                <h1 class="text-2xl font-bold text-white">@yield('title')</h1>
            </header>

            {{-- Page Content --}}
            <div class="p-8">
                {{-- Success Messages --}}
                @if(session('success'))
                <div class="bg-green-500/20 backdrop-blur-sm border border-green-500/30 text-green-300 px-4 py-3 rounded-xl mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                {{-- Error Messages --}}
                @if(session('error'))
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>