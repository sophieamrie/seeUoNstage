<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - E-Ticket</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f5f7fb;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            padding: 25px 20px;
            border-right: 1px solid #e2e8f0;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 8px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #4f46e5;
            color: white !important;
        }

        .content-area {
            margin-left: 260px;
            padding: 30px 40px;
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h4 class="fw-bold mb-4">🎫 E-Ticket</h4>

        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('bookings.index') }}" class="{{ request()->is('bookings*') ? 'active' : '' }}">📅 My Bookings</a>
        <a href="{{ route('favorites.index') }}" class="{{ request()->is('favorites*') ? 'active' : '' }}">⭐ Favorites</a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">👤 Profile</a>
        <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">🏠 Home</a>


        <hr>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    {{-- Page Content --}}
    <div class="content-area">
        @yield('content')
    </div>

</body>
</html>
