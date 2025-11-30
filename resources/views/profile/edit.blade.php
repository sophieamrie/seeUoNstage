@extends('layouts.user')

@section('title', 'Profile Settings')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Profile Settings</h1>
            <p class="text-gray-400 mt-1">Manage your account information and preferences</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('status') === 'profile-updated')
    <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm rounded-xl p-4 text-green-300">
        <i class="fas fa-check-circle mr-2"></i>Profile updated successfully!
    </div>
    @endif

    @if(session('status') === 'password-updated')
    <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm rounded-xl p-4 text-green-300">
        <i class="fas fa-check-circle mr-2"></i>Password updated successfully!
    </div>
    @endif

    {{-- Profile Information Card --}}
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden">
        <div class="relative h-32 bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,.05) 2px, rgba(255,255,255,.05) 4px);"></div>
        </div>
        
        <div class="px-8 pb-8 -mt-16 relative z-10">
            {{-- Avatar --}}
            <div class="flex items-end space-x-6 mb-6">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-5xl font-bold border-4 border-gray-800 shadow-2xl">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="pb-2">
                    <h2 class="text-2xl font-bold text-white">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-400">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-500/20 border border-blue-500/50 text-blue-300 text-xs font-semibold rounded-full">
                        <i class="fas fa-user mr-1"></i>{{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            {{-- Profile Information Form --}}
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name Field --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-white mb-2">
                            <i class="fas fa-user mr-2 text-purple-400"></i>Full Name
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', auth()->user()->name) }}"
                            required
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                            placeholder="Enter your full name"
                        >
                        @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-white mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-400"></i>Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                            placeholder="Enter your email"
                        >
                        @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-full font-bold hover:from-purple-700 hover:to-pink-700 transition shadow-lg hover:shadow-purple-500/50"
                    >
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Update Password Card --}}
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-xl p-8">
        <div class="flex items-start space-x-4 mb-6">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-lock text-yellow-400 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white">Update Password</h3>
                <p class="text-gray-400 text-sm mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div>
                <label for="update_password_current_password" class="block text-sm font-semibold text-white mb-2">
                    <i class="fas fa-key mr-2 text-gray-400"></i>Current Password
                </label>
                <input 
                    type="password" 
                    id="update_password_current_password" 
                    name="current_password"
                    autocomplete="current-password"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition"
                    placeholder="Enter your current password"
                >
                @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label for="update_password_password" class="block text-sm font-semibold text-white mb-2">
                    <i class="fas fa-key mr-2 text-green-400"></i>New Password
                </label>
                <input 
                    type="password" 
                    id="update_password_password" 
                    name="password"
                    autocomplete="new-password"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition"
                    placeholder="Enter your new password"
                >
                @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-semibold text-white mb-2">
                    <i class="fas fa-key mr-2 text-green-400"></i>Confirm New Password
                </label>
                <input 
                    type="password" 
                    id="update_password_password_confirmation" 
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition"
                    placeholder="Confirm your new password"
                >
                @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Update Password Button --}}
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-8 py-3 rounded-full font-bold hover:from-yellow-700 hover:to-orange-700 transition shadow-lg hover:shadow-yellow-500/50"
                >
                    <i class="fas fa-shield-alt mr-2"></i>Update Password
                </button>
            </div>
        </form>
    </div>

    {{-- Delete Account Card --}}
    <div class="bg-red-500/10 backdrop-blur-sm border border-red-500/30 rounded-xl p-8">
        <div class="flex items-start space-x-4 mb-6">
            <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white">Delete Account</h3>
                <p class="text-gray-400 text-sm mt-1">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-white mb-2">
                    <i class="fas fa-key mr-2 text-red-400"></i>Confirm Password to Delete
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Enter your password to confirm deletion"
                    class="w-full bg-white/5 border border-red-500/30 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition"
                >
                @error('password', 'userDeletion')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-red-600 text-white px-8 py-3 rounded-full font-bold hover:bg-red-700 transition shadow-lg hover:shadow-red-500/50"
                >
                    <i class="fas fa-trash-alt mr-2"></i>Delete Account
                </button>
            </div>
        </form>
    </div>

    {{-- Info Card --}}
    <div class="relative rounded-xl overflow-hidden" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,.03) 2px, rgba(255,255,255,.03) 4px), linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);">
        <div class="p-6 text-white relative z-10">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-1">Need Help?</h4>
                    <p class="text-sm text-purple-100">If you have any questions about your account settings, feel free to contact our support team.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection