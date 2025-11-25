<nav class="d-flex flex-column p-3 bg-white border-end" style="width: 250px; height: 100vh;">
    <h4 class="mb-4">
        <span class="me-2">🎫</span> E-Ticket
    </h4>

    {{-- HOME --}}
    <a href="{{ route('home') }}"
       class="d-flex align-items-center mb-3 text-decoration-none {{ request()->routeIs('home') ? 'fw-bold text-primary' : 'text-dark' }}">
        <span class="me-2">🏠</span> Home
    </a>

    {{-- DASHBOARD --}}
    <a href="{{ route('dashboard') }}"
       class="d-flex align-items-center mb-3 text-decoration-none {{ request()->routeIs('dashboard') ? 'fw-bold text-primary' : 'text-dark' }}">
        <span class="me-2">📋</span> Dashboard
    </a>

    {{-- MY BOOKINGS --}}
    <a href="{{ route('bookings.index') }}"
       class="d-flex align-items-center mb-3 text-decoration-none {{ request()->routeIs('bookings.*') ? 'fw-bold text-primary' : 'text-dark' }}">
        <span class="me-2">📅</span> My Bookings
    </a>

    {{-- FAVORITES --}}
    <a href="{{ route('favorites.index') }}"
       class="d-flex align-items-center mb-3 text-decoration-none {{ request()->routeIs('favorites.*') ? 'fw-bold text-primary' : 'text-dark' }}">
        <span class="me-2">⭐</span> Favorites
    </a>

    {{-- PROFILE --}}
    <a href="{{ route('profile.edit') }}"
       class="d-flex align-items-center mb-3 text-decoration-none {{ request()->routeIs('profile.*') ? 'fw-bold text-primary' : 'text-dark' }}">
        <span class="me-2">👤</span> Profile
    </a>

    {{-- LOGOUT --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button class="btn btn-link text-decoration-none text-danger">
            <span class="me-2">🚪</span> Logout
        </button>
    </form>
</nav>
