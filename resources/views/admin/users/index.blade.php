@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'User Management')

@section('content')
<!-- Pending Organizers Section -->
@if($pendingOrganizers->count() > 0)
<div class="bg-orange-500/10 backdrop-blur-sm border border-orange-500/30 rounded-2xl mb-8 overflow-hidden">
    <div class="p-6 border-b border-orange-500/30 bg-orange-500/5">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-circle text-orange-400"></i>
                </div>
                Pending Approvals
            </h3>
            <span class="px-3 py-1 bg-orange-500/20 text-orange-300 rounded-full text-sm font-semibold">
                {{ $pendingOrganizers->count() }} waiting
            </span>
        </div>
    </div>
    <div class="p-6">
        <div class="space-y-3">
            @foreach($pendingOrganizers as $organizer)
            <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl p-5 hover:border-orange-500/50 transition">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($organizer->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $organizer->name }}</p>
                            <p class="text-sm text-gray-400">{{ $organizer->email }}</p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-orange-500/20 text-orange-300 rounded-lg">
                                Organizer • Pending
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.users.approve', $organizer) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500/20 hover:bg-green-500/30 text-green-300 rounded-xl font-semibold transition border border-green-500/30">
                                <i class="fas fa-check mr-1"></i> Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.reject', $organizer) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-xl font-semibold transition border border-red-500/30">
                                <i class="fas fa-times mr-1"></i> Reject
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- All Users Section -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white">All Users</h3>
            <p class="text-sm text-gray-400">Total: <span class="text-white font-semibold">{{ $users->total() }}</span></p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Registered</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <span class="font-medium text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs rounded-lg font-semibold
                            @if($user->role === 'admin') bg-red-500/20 text-red-300 border border-red-500/30
                            @elseif($user->role === 'organizer') bg-blue-500/20 text-blue-300 border border-blue-500/30
                            @else bg-gray-500/20 text-gray-300 border border-gray-500/30
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs rounded-lg font-semibold
                            @if($user->status === 'active') bg-green-500/20 text-green-300 border border-green-500/30
                            @elseif($user->status === 'pending') bg-orange-500/20 text-orange-300 border border-orange-500/30
                            @elseif($user->status === 'rejected') bg-red-500/20 text-red-300 border border-red-500/30
                            @else bg-gray-500/20 text-gray-300 border border-gray-500/30
                            @endif">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'organizer' && $user->status === 'pending')
                        <div class="flex justify-center gap-2">
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-green-500/20 hover:bg-green-500/30 text-green-400 rounded-lg transition flex items-center justify-center border border-green-500/30" title="Approve">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition flex items-center justify-center border border-red-500/30" title="Reject">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        </div>
                        @elseif($user->role === 'user')
                        <div class="flex justify-center gap-2">
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition flex items-center justify-center border border-red-500/30" title="Delete User">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="text-center">
                            <span class="text-gray-600">-</span>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-users text-gray-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-400">No users found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($users->hasPages())
    <div class="p-6 border-t border-white/10">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection