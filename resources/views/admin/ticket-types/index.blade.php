@extends('layouts.admin')

@section('title', 'Manage Tickets')
@section('page-title', 'Ticket Management')

@section('content')

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-purple-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $ticketTypes->total() }}</p>
            <p class="text-sm text-gray-400">Ticket Types</p>
        </div>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $bookings->count() }}</p>
            <p class="text-sm text-gray-400">Total Bookings</p>
        </div>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $bookings->where('status', 'pending')->count() }}</p>
            <p class="text-sm text-gray-400">Pending Bookings</p>
        </div>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $ticketTypes->sum('sold') }}</p>
            <p class="text-sm text-gray-400">Total Sold</p>
        </div>
    </div>
</div>

<!-- Ticket Types Table -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden mb-8">
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white">Ticket Types</h3>
            <p class="text-sm text-gray-400">Showing <span class="text-white font-semibold">{{ $ticketTypes->count() }}</span> types</p>
        </div>
    </div>

    @if($ticketTypes->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Ticket Info</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Event</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Quota</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Sold</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($ticketTypes as $ticket)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $ticket->name }}</p>
                                @if($ticket->description)
                                <p class="text-xs text-gray-400">{{ Str::limit($ticket->description, 30) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-white">{{ Str::limit($ticket->event->title, 25) }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->event->start_datetime->format('M d, Y') }}</p>
                    </td>
                    <td class="px-6 py-4 font-semibold text-green-400">
                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        {{ number_format($ticket->quota) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded-lg font-semibold">
                            {{ number_format($ticket->sold) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($ticket->status) === 'pending')
                        <span class="px-3 py-1 text-xs bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 rounded-lg font-semibold">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @elseif(strtolower($ticket->status) === 'approved')
                        <span class="px-3 py-1 text-xs bg-green-500/20 text-green-300 border border-green-500/30 rounded-lg font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif(strtolower($ticket->status) === 'rejected')
                        <span class="px-3 py-1 text-xs bg-red-500/20 text-red-300 border border-red-500/30 rounded-lg font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($ticket->status) === 'pending')
                        <div class="flex justify-center gap-2">
                            <form action="{{ route('admin.ticket-types.approve', $ticket) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-green-500/20 hover:bg-green-500/30 text-green-400 rounded-lg transition flex items-center justify-center border border-green-500/30" title="Approve">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.ticket-types.reject', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this ticket type?')">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition flex items-center justify-center border border-red-500/30" title="Reject">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.ticket-types.edit', $ticket) }}" class="w-8 h-8 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 rounded-lg transition flex items-center justify-center border border-blue-500/30" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                        </div>
                        @else
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.ticket-types.edit', $ticket) }}" class="w-8 h-8 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 rounded-lg transition flex items-center justify-center border border-blue-500/30" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.ticket-types.destroy', $ticket) }}" onsubmit="return confirm('Are you sure you want to delete this ticket type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition flex items-center justify-center border border-red-500/30" title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($ticketTypes->hasPages())
    <div class="p-6 border-t border-white/10">
        {{ $ticketTypes->links() }}
    </div>
    @endif
    @else
    <div class="p-12 text-center">
        <div class="w-20 h-20 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
            <i class="fas fa-ticket-alt text-gray-600 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">No Ticket Types Yet</h3>
        <p class="text-gray-400">Ticket types will appear here once organizers create them</p>
    </div>
    @endif
</div>

<!-- All Bookings Table -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/10 bg-white/5">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-white">All Bookings</h2>
            <p class="text-sm text-gray-400">Total: <span class="text-white font-semibold">{{ $bookings->count() }}</span></p>
        </div>
    </div>

    @if($bookings->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-white/5 border-b border-white/10">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Booking ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Organizer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Ticket Type</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty</th>
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
                    <td class="px-6 py-4">
                        <p class="text-gray-300 text-sm">{{ $booking->event->organizer->name ?? 'N/A' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-300">
                        {{ $booking->ticketType->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-white font-semibold">
                        {{ $booking->quantity }}
                    </td>
                    <td class="px-6 py-4 text-green-400 font-semibold">
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
                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-400 hover:text-green-300 hover:bg-green-500/10 px-3 py-2 rounded-lg transition" title="Approve">
                                    <i class="fas fa-check text-lg"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this booking?')">
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
            <i class="fas fa-shopping-cart text-purple-400 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-white mb-3">No Bookings Yet</h3>
        <p class="text-gray-400">Bookings from all events will appear here</p>
    </div>
    @endif
</div>
@endsection