@extends('layouts.organizer')

@section('title', 'Manage Bookings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Booking Management</h1>
            <p class="text-gray-400 mt-1">Review and manage ticket bookings for your events</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-400 text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $bookings->count() }}</h3>
            <p class="text-sm text-gray-400">Total Bookings</p>
        </div>

        <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-400 text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $bookings->filter(function($b) { return strtolower($b->status) === 'pending'; })->count() }}</h3>
            <p class="text-sm text-gray-400">Pending Approval</p>
        </div>

        <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
            </div>
           <h3 class="text-3xl font-bold text-white mb-1">{{ $bookings->filter(function($b) { return strtolower($b->status) === 'approved'; })->count() }}</h3>
            <p class="text-sm text-gray-400">Approved</p>
        </div>

        <div class="glass rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:-translate-y-1 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-400 text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $bookings->filter(function($b) { return strtolower($b->status) === 'rejected'; })->count() }}</h3>
            <p class="text-sm text-gray-400">Rejected</p>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="glass rounded-2xl border border-white/10 overflow-hidden">
        <div class="p-6 border-b border-white/10 bg-white/5">
            <h2 class="text-2xl font-bold text-white">All Bookings</h2>
        </div>

        @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Ticket Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-purple-400">#{{ $booking->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-white">{{ $booking->user->name }}</p>
                                <p class="text-sm text-gray-400">{{ $booking->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($booking->event->image_url)
                                <img src="{{ asset('storage/' . $booking->event->image_url) }}" alt="{{ $booking->event->title }}" class="w-12 h-12 object-cover rounded-xl mr-3 shadow-md">
                                @else
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-image text-white"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-white text-sm">{{ Str::limit($booking->event->title, 30) }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->event->start_datetime->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            {{ $booking->ticketType->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-white font-semibold">
                            {{ $booking->quantity }}
                        </td>
                        <td class="px-6 py-4 text-white font-semibold">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if(strtolower($booking->status) === 'pending')
                            <span class="px-3 py-1.5 text-xs bg-yellow-500/20 border border-yellow-500/50 text-yellow-300 rounded-full font-medium">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                            @elseif($booking->status === 'approved')
                            <span class="px-3 py-1.5 text-xs bg-green-500/20 border border-green-500/50 text-green-300 rounded-full font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                            </span>
                            @elseif($booking->status === 'rejected')
                            <span class="px-3 py-1.5 text-xs bg-red-500/20 border border-red-500/50 text-red-300 rounded-full font-medium">
                                <i class="fas fa-times-circle mr-1"></i>Rejected
                            </span>
                            @else
                            <span class="px-3 py-1.5 text-xs bg-gray-500/20 border border-gray-500/50 text-gray-300 rounded-full font-medium">
                                {{ ucfirst($booking->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(strtolower($booking->status) === 'pending')
                            <div class="flex space-x-2">
                                <!-- Approve Button -->
                                <form action="{{ route('organizer.bookings.approve', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-400 hover:text-green-300 hover:bg-green-500/10 px-3 py-2 rounded-lg transition" title="Approve">
                                        <i class="fas fa-check text-lg"></i>
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <form action="{{ route('organizer.bookings.reject', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this booking?')">
                                    @csrf
                                    <button type="submit" class="text-red-400 hover:text-red-300 hover:bg-red-500/10 px-3 py-2 rounded-lg transition" title="Reject">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-500 text-sm">No actions</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-16 text-center">
            <div class="w-24 h-24 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-purple-500/30">
                <i class="fas fa-ticket-alt text-purple-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">No Bookings Yet</h3>
            <p class="text-gray-400">Bookings for your events will appear here</p>
        </div>
        @endif
    </div>

    <!-- Quick Tips -->
    <div class="glass rounded-2xl p-6 border border-blue-500/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="flex items-start relative z-10">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg">
                <i class="fas fa-lightbulb text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white mb-3">Booking Management Tips</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Review and approve bookings promptly to ensure customer satisfaction</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Check ticket availability before approving to avoid overbooking</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Communicate clearly with customers about rejected bookings</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection