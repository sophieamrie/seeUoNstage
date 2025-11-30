@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">My Bookings</h1>
            <p class="text-gray-400 mt-1">View and manage your concert ticket bookings</p>
        </div>
        <a href="{{ route('events.index') }}" class="bg-white text-gray-900 px-6 py-3 rounded-full font-bold hover:bg-gray-100 transition">
            <i class="fas fa-plus mr-2"></i>Book New Ticket
        </a>
    </div>

    {{-- Filter Tabs --}}
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl p-2 flex space-x-2">
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
        <div class="booking-card bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl hover:border-purple-500/50 hover:shadow-2xl transition p-6" data-status="{{ strtolower($booking->status) }}">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                
                {{-- Left: Event Info --}}
                <div class="flex items-start space-x-4 flex-1">
                    {{-- Event Image --}}
                    @if($booking->event->image_url)
                    <img src="{{ asset('storage/' . $booking->event->image_url) }}" alt="{{ $booking->event->title }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                    @else
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-music text-white text-2xl"></i>
                    </div>
                    @endif

                    {{-- Event Details --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-bold text-white mb-1">{{ $booking->event->title }}</h3>
                        
                        @if($booking->event->artist)
                        <p class="text-purple-400 font-medium mb-2">{{ $booking->event->artist }}</p>
                        @endif

                        <div class="space-y-1 text-sm text-gray-400">
                            <p>
                                <i class="fas fa-ticket-alt w-4 text-purple-400"></i>
                                <span class="font-semibold">{{ $booking->ticketType->name }}</span> × {{ $booking->quantity }}
                            </p>
                            <p>
                                <i class="fas fa-calendar w-4 text-blue-400"></i>
                                {{ $booking->event->start_datetime->format('l, F d, Y • h:i A') }}
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt w-4 text-red-400"></i>
                                {{ $booking->event->location }}
                            </p>
                            <p>
                                <i class="fas fa-clock w-4 text-gray-500"></i>
                                Booked {{ $booking->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            Booking Code: <span class="font-mono font-semibold text-purple-400">{{ $booking->booking_code }}</span>
                        </p>
                    </div>
                </div>

                {{-- Right: Price & Actions --}}
                <div class="lg:text-right space-y-3 lg:pl-6 lg:border-l lg:border-white/10">
                    {{-- Price --}}
                    <div>
                        <p class="text-sm text-gray-400">Total Price</p>
                        <p class="text-2xl font-bold text-purple-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Status Badge --}}
                    <div>
                        @if(strtolower($booking->status) === 'pending')
                        <span class="inline-block px-4 py-2 text-sm bg-yellow-500/20 border border-yellow-500/30 text-yellow-300 rounded-full font-semibold">
                            <i class="fas fa-clock mr-1"></i>Pending Approval
                        </span>
                        @elseif(strtolower($booking->status) === 'approved')
                        <span class="inline-block px-4 py-2 text-sm bg-green-500/20 border border-green-500/30 text-green-300 rounded-full font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif(strtolower($booking->status) === 'rejected')
                        <span class="inline-block px-4 py-2 text-sm bg-red-500/20 border border-red-500/30 text-red-300 rounded-full font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @elseif(strtolower($booking->status) === 'cancelled')
                        <span class="inline-block px-4 py-2 text-sm bg-gray-500/20 border border-gray-500/30 text-gray-300 rounded-full font-semibold">
                            <i class="fas fa-ban mr-1"></i>Cancelled
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col space-y-2">
                        @if(strtolower($booking->status) === 'approved')
                        <a href="{{ route('bookings.show', $booking) }}" class="bg-white text-gray-900 px-6 py-2 rounded-full text-sm font-bold hover:bg-gray-100 transition text-center">
                            <i class="fas fa-ticket-alt mr-2"></i>View Ticket
                        </a>
                        @endif

                        @if(strtolower($booking->status) === 'pending' && now()->lessThan($booking->cancellable_until))
                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                            @csrf
                            <button type="submit" class="w-full bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-300 px-6 py-2 rounded-full text-sm font-bold transition">
                                <i class="fas fa-times mr-2"></i>Cancel Booking
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('events.show', $booking->event) }}" class="bg-white/10 hover:bg-white/20 border border-white/10 text-white px-6 py-2 rounded-full text-sm font-bold transition text-center">
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
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl p-12 text-center">
        <div class="w-32 h-32 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-ticket-alt text-purple-400 text-5xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-white mb-3">No Bookings Yet</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            You haven't booked any concert tickets yet. Start exploring amazing events and book your first ticket!
        </p>
        <a href="{{ route('events.index') }}" class="inline-block bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
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
        btn.classList.remove('active', 'bg-white', 'text-gray-900');
        btn.classList.add('text-gray-400', 'hover:bg-white/5');
    });
    event.target.classList.add('active', 'bg-white', 'text-gray-900');
    event.target.classList.remove('text-gray-400', 'hover:bg-white/5');
    
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
        activeBtn.classList.add('bg-white', 'text-gray-900');
        activeBtn.classList.remove('text-gray-400');
    }
    
    // Add hover states to inactive buttons
    document.querySelectorAll('.filter-btn:not(.active)').forEach(btn => {
        btn.classList.add('text-gray-400', 'hover:bg-white/5');
    });
});
</script>
@endsection