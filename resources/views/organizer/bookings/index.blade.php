@extends('layouts.organizer')

@section('title', 'Manage Bookings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Booking Management</h1>
            <p class="text-gray-600 mt-1">Review and manage ticket bookings for your events</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $bookings->count() }}</h3>
            <p class="text-sm text-gray-600">Total Bookings</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'pending')->count() }}</h3>
            <p class="text-sm text-gray-600">Pending Approval</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'approved')->count() }}</h3>
            <p class="text-sm text-gray-600">Approved</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'rejected')->count() }}</h3>
            <p class="text-sm text-gray-600">Rejected</p>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">All Bookings</h2>
        </div>

        @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm text-gray-600">#{{ $booking->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $booking->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($booking->event->image_url)
                                <img src="{{ asset('storage/' . $booking->event->image_url) }}" alt="{{ $booking->event->title }}" class="w-10 h-10 object-cover rounded mr-3">
                                @else
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded flex items-center justify-center mr-3">
                                    <i class="fas fa-image text-white text-xs"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ Str::limit($booking->event->title, 30) }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->event->start_datetime->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $booking->ticketType->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-semibold">
                            {{ $booking->quantity }}
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-semibold">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($booking->status === 'pending')
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                            @elseif($booking->status === 'approved')
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                            </span>
                            @elseif($booking->status === 'rejected')
                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                <i class="fas fa-times-circle mr-1"></i>Rejected
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                {{ ucfirst($booking->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($booking->status === 'pending')
                            <div class="flex space-x-2">
                                <!-- Approve Button -->
                                <form action="{{ route('organizer.bookings.approve', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 px-3 py-1 rounded hover:bg-green-50 transition" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <form action="{{ route('organizer.bookings.reject', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this booking?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 px-3 py-1 rounded hover:bg-red-50 transition" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">No actions</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-ticket-alt text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Bookings Yet</h3>
            <p class="text-gray-600">Bookings for your events will appear here</p>
        </div>
        @endif
    </div>
</div>
@endsection