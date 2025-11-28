@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Bookings</h1>
            <p class="text-gray-600 mt-1">View and manage your concert ticket bookings</p>
        </div>
        <a href="{{ route('events.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i>Book New Ticket
        </a>
    </div>

    {{-- Filter Tabs --}}
    <div class="bg-white rounded-lg shadow p-2 flex space-x-2">
        <button onclick="filterBookings('all')" class="filter-btn active px-6 py-2 rounded-lg font-medium transition">
            All Bookings
        </button>
        <button onclick="filterBookings('pending')" class="filter-btn px-6 py-2 rounded-lg font-medium transition">
            Pending
        </button>
        <button onclick="filterBookings('approved')" class="filter-btn px-6 py-2 rounded-lg font-medium transition">
            Approved
        </button>
        <button onclick="filterBookings('rejected')" class="filter-btn px-6 py-2 rounded-lg font-medium transition">
            Rejected
        </button>
        <button onclick="filterBookings('cancelled')" class="filter-btn px-6 py-2 rounded-lg font-medium transition">
            Cancelled
        </button>
    </div>

    {{-- Bookings List --}}
    @if($bookings->count() > 0)
    <div class="space-y-4" id="bookings-container">
        @foreach($bookings as $booking)
        <div class="booking-card bg-white rounded-xl shadow hover:shadow-lg transition p-6" data-status="{{ strtolower($booking->status) }}">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                
                {{-- Left: Event Info --}}
                <div class="flex items-start space-x-4 flex-1">
                    {{-- Event Image --}}
                    @if($booking->event->image_url)
                    <img src="{{ asset('storage/' . $booking->event->image_url) }}" alt="{{ $booking->event->title }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                    @else
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-music text-white text-2xl"></i>
                    </div>
                    @endif

                    {{-- Event Details --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $booking->event->title }}</h3>
                        
                        @if($booking->event->artist)
                        <p class="text-purple-600 font-medium mb-2">{{ $booking->event->artist }}</p>
                        @endif

                        <div class="space-y-1 text-sm text-gray-600">
                            <p>
                                <i class="fas fa-ticket-alt w-4 text-purple-600"></i>
                                <span class="font-semibold">{{ $booking->ticketType->name }}</span> × {{ $booking->quantity }}
                            </p>
                            <p>
                                <i class="fas fa-calendar w-4 text-blue-600"></i>
                                {{ $booking->event->start_datetime->format('l, F d, Y • h:i A') }}
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt w-4 text-red-600"></i>
                                {{ $booking->event->location }}
                            </p>
                            <p>
                                <i class="fas fa-clock w-4 text-gray-600"></i>
                                Booked {{ $booking->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            Booking Code: <span class="font-mono font-semibold">{{ $booking->booking_code }}</span>
                        </p>
                    </div>
                </div>

                {{-- Right: Price & Actions --}}
                <div class="lg:text-right space-y-3 lg:pl-6 lg:border-l">
                    {{-- Price --}}
                    <div>
                        <p class="text-sm text-gray-600">Total Price</p>
                        <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Status Badge --}}
                    <div>
                        @if(strtolower($booking->status) === 'pending')
                        <span class="inline-block px-4 py-2 text-sm bg-yellow-100 text-yellow-700 rounded-full font-semibold">
                            <i class="fas fa-clock mr-1"></i>Pending Approval
                        </span>
                        @elseif(strtolower($booking->status) === 'approved')
                        <span class="inline-block px-4 py-2 text-sm bg-green-100 text-green-700 rounded-full font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif(strtolower($booking->status) === 'rejected')
                        <span class="inline-block px-4 py-2 text-sm bg-red-100 text-red-700 rounded-full font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @elseif(strtolower($booking->status) === 'cancelled')
                        <span class="inline-block px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-full font-semibold">
                            <i class="fas fa-ban mr-1"></i>Cancelled
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col space-y-2">
                        @if(strtolower($booking->status) === 'approved')
                        <a href="{{ route('bookings.show', $booking) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-semibold transition text-center">
                            <i class="fas fa-ticket-alt mr-2"></i>View Ticket
                        </a>
                        @endif

                        @if(strtolower($booking->status) === 'pending' && now()->lessThan($booking->cancellable_until))
                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                            @csrf
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-6 py-2 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-times mr-2"></i>Cancel Booking
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('events.show', $booking->event) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition text-center">
                            <i class="fas fa-eye mr-2"></i>View Event
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
    @else
    {{-- Empty State --}}
    <div class="bg-white rounded-xl shadow p-12 text-center">
        <div class="w-32 h-32 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-ticket-alt text-purple-600 text-5xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">No Bookings Yet</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            You haven't booked any concert tickets yet. Start exploring amazing events and book your first ticket!
        </p>
        <a href="{{ route('events.index') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-search mr-2"></i>Browse Events
        </a>
    </div>
    @endif

</div>

<script>
function filterBookings(status) {
    const bookings = document.querySelectorAll('.booking-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-purple-600', 'text-white');
        btn.classList.add('text-gray-600', 'hover:bg-gray-100');
    });
    event.target.classList.add('active', 'bg-purple-600', 'text-white');
    event.target.classList.remove('text-gray-600', 'hover:bg-gray-100');
    
    // Filter bookings
    bookings.forEach(booking => {
        if (status === 'all') {
            booking.style.display = 'block';
        } else {
            if (booking.dataset.status === status) {
                booking.style.display = 'block';
            } else {
                booking.style.display = 'none';
            }
        }
    });
}

// Set initial active state
document.addEventListener('DOMContentLoaded', function() {
    const activeBtn = document.querySelector('.filter-btn.active');
    if (activeBtn) {
        activeBtn.classList.add('bg-purple-600', 'text-white');
        activeBtn.classList.remove('text-gray-600');
    }
    
    // Add hover states to inactive buttons
    document.querySelectorAll('.filter-btn:not(.active)').forEach(btn => {
        btn.classList.add('text-gray-600', 'hover:bg-gray-100');
    });
});
</script>
@endsection