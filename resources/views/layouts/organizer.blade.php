<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="w-64 bg-gradient-to-b from-purple-900 to-indigo-900 text-white">
            <!-- Your sidebar content here -->
            <div class="p-6">
                <h2 class="text-2xl font-bold">seeUoNstage</h2>
                <p class="text-sm text-purple-200">Organizer Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('organizer.dashboard') }}" class="block px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('organizer.events.index') }}" class="block px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-calendar mr-2"></i> Events
                </a>
                <a href="{{ route('organizer.bookings.index') }}" class="block px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-ticket-alt mr-2"></i> Bookings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>