@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<!-- Pending Organizers Section -->
@if($pendingOrganizers->count() > 0)
<div class="bg-white rounded-lg shadow mb-8">
    <div class="p-6 border-b bg-orange-50">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-exclamation-circle text-orange-500 mr-2"></i>
            Pending Organizer Approvals ({{ $pendingOrganizers->count() }})
        </h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            @foreach($pendingOrganizers as $organizer)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 font-bold text-lg">{{ strtoupper(substr($organizer->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $organizer->name }}</p>
                        <p class="text-sm text-gray-600">{{ $organizer->email }}</p>
                        <span class="inline-block mt-1 px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">
                            Pending Approval
                        </span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <form method="POST" action="{{ route('admin.users.approve', $organizer) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            <i class="fas fa-check mr-1"></i> Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.reject', $organizer) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            <i class="fas fa-times mr-1"></i> Reject
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- All Users Section -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs rounded-full font-medium
                            @if($user->role === 'admin') bg-red-100 text-red-700
                            @elseif($user->role === 'organizer') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs rounded-full font-medium
                            @if($user->status === 'active') bg-green-100 text-green-700
                            @elseif($user->status === 'pending') bg-orange-100 text-orange-700
                            @elseif($user->status === 'rejected') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'organizer' && $user->status === 'pending')
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No users found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="p-6 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection