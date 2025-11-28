@extends('layouts.admin')

@section('title', 'Manage Ticket Types')
@section('page-title', 'Manage Ticket Types')

@section('content')
<!-- Create Button -->
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.ticket-types.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
        <i class="fas fa-plus mr-2"></i>Create Ticket Type
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Ticket Types</p>
                <p class="text-3xl font-bold text-gray-800">{{ $ticketTypes->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-ticket-alt text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Pending Approval</p>
                <p class="text-3xl font-bold text-gray-800">{{ $ticketTypes->where('status', 'pending')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Events</p>
                <p class="text-3xl font-bold text-gray-800">{{ $events->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Sold</p>
                <p class="text-3xl font-bold text-gray-800">{{ $ticketTypes->sum('sold') }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">All Ticket Types</h3>
        <div class="flex space-x-2">
            <input type="text" placeholder="Search tickets..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
    </div>

    @if($ticketTypes->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Info</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sold</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($ticketTypes as $ticket)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $ticket->name }}</p>
                                @if($ticket->description)
                                <p class="text-xs text-gray-500">{{ Str::limit($ticket->description, 30) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $ticket->event->title }}</p>
                        <p class="text-xs text-gray-500">{{ $ticket->event->start_datetime->format('M d, Y') }}</p>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ number_format($ticket->quota) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded font-medium">
                            {{ number_format($ticket->sold) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($ticket->status) === 'pending')
                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @elseif(strtolower($ticket->status) === 'approved')
                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif(strtolower($ticket->status) === 'rejected')
                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($ticket->status) === 'pending')
                        <div class="flex space-x-2">
                            <form action="{{ route('admin.ticket-types.approve', $ticket) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 px-3 py-1 rounded hover:bg-green-50 transition" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.ticket-types.reject', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this ticket type?')">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 px-3 py-1 rounded hover:bg-red-50 transition" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.ticket-types.edit', $ticket) }}" class="text-blue-600 hover:text-blue-800 px-3 py-1 rounded hover:bg-blue-50 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        @else
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.ticket-types.edit', $ticket) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.ticket-types.destroy', $ticket) }}" onsubmit="return confirm('Are you sure you want to delete this ticket type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <i class="fas fa-trash"></i>
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

    <!-- Pagination -->
    <div class="p-6 border-t">
        {{ $ticketTypes->links() }}
    </div>
    @else
    <div class="p-12 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-ticket-alt text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Ticket Types Yet</h3>
        <p class="text-gray-600 mb-4">Create your first ticket type to get started</p>
        <a href="{{ route('admin.ticket-types.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-plus mr-2"></i>Create Ticket Type
        </a>
    </div>
    @endif
</div>
@endsection