<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Panel - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

            <div class="text-xl font-bold text-indigo-600">
                Organizer Panel
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('organizer.dashboard') }}" 
                   class="text-gray-700 hover:text-indigo-600">
                    Dashboard
                </a>

                <a href="{{ route('organizer.events.index') }}" 
                   class="text-gray-700 hover:text-indigo-600">
                    Events
                </a>

                <a href="{{ route('organizer.ticket-types.index') }}" 
                   class="text-gray-700 hover:text-indigo-600">
                    Ticket Types
                </a>

                <a href="{{ route('organizer.bookings.index') }}" 
                   class="text-gray-700 hover:text-indigo-600">
                    Bookings
                </a>

                <!-- USER DROPDOWN -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 font-medium hover:text-red-800">Logout</button>
                </form>
            </div>

        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="max-w-7xl mx-auto mt-6 px-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
