<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gradient-to-b from-purple-900 to-indigo-900 text-white flex flex-col">
            
            {{-- Logo --}}
            <div class="p-6 border-b border-purple-700">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-music mr-2"></i>
                    seeUoNstage
                </h2>
                <p class="text-xs text-purple-200 mt-1">User Dashboard</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('dashboard') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-800' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>

                <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('bookings*') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-800' }}">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span class="ml-3 font-medium">My Bookings</span>
                </a>

                <a href="{{ route('favorites.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('favorites*') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-800' }}">
                    <i class="fas fa-heart w-5"></i>
                    <span class="ml-3 font-medium">Favorites</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('profile*') ? 'bg-purple-700 text-white' : 'text-purple-100 hover:bg-purple-800' }}">
                    <i class="fas fa-user w-5"></i>
                    <span class="ml-3 font-medium">Profile</span>
                </a>

                <hr class="border-purple-700 my-4">

                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg transition text-purple-100 hover:bg-purple-800">
                    <i class="fas fa-globe w-5"></i>
                    <span class="ml-3 font-medium">Back to Website</span>
                </a>
            </nav>

            {{-- User Info & Logout --}}
            <div class="p-4 border-t border-purple-700">
                <div class="flex items-center mb-3 px-2">
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-3 flex-1 overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-purple-300 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-semibold transition flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm px-8 py-4 border-b">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            </header>

            {{-- Page Content --}}
            <div class="p-8">
                {{-- Success Messages --}}
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Error Messages --}}
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>