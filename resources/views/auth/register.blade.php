<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
            background: #111827;
            background-image: 
                radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(236, 72, 153, 0.2) 0px, transparent 50%);
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .role-card {
            transition: all 0.3s ease;
        }
        
        .role-card input:checked ~ div {
            border-color: rgb(168, 85, 247);
        }
        
        .role-card:has(input:checked) {
            background: rgba(168, 85, 247, 0.1);
            border-color: rgb(168, 85, 247);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 py-12 relative">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 grid-pattern opacity-30 pointer-events-none"></div>
    
    <!-- Floating Decorative Elements -->
    <div class="absolute top-20 left-20 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl floating-shape pointer-events-none"></div>
    <div class="absolute bottom-20 right-20 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl floating-shape pointer-events-none" style="animation-delay: 2s;"></div>
    
    <div class="w-full max-w-md relative z-10">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                    seeUoNstage
                </h1>
            </a>
            <p class="text-gray-400 text-lg">Create your account</p>
        </div>

        <!-- Register Card -->
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-white/10 p-8 shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-6">Get started</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Full name
                    </label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name"
                        class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                        placeholder="John Doe"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="username"
                        class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Confirm password
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        I want to
                    </label>
                    <div class="space-y-3">
                        <label class="role-card flex items-start p-4 border border-white/10 rounded-xl cursor-pointer">
                            <input 
                                type="radio" 
                                name="role" 
                                value="user" 
                                checked
                                class="mt-1 text-purple-500 border-white/10 bg-gray-900/50 focus:ring-purple-500/20"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-white block">Browse events</span>
                                <p class="text-sm text-gray-400 mt-1">Discover and book tickets for events</p>
                            </div>
                        </label>
                        <label class="role-card flex items-start p-4 border border-white/10 rounded-xl cursor-pointer">
                            <input 
                                type="radio" 
                                name="role" 
                                value="organizer"
                                class="mt-1 text-purple-500 border-white/10 bg-gray-900/50 focus:ring-purple-500/20"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-white block">Create events</span>
                                <p class="text-sm text-gray-400 mt-1">Organize and manage your own events</p>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full bg-white text-gray-900 py-3 rounded-xl font-bold hover:bg-gray-100 transition shadow-lg"
                >
                    Create account
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/10"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-gray-800/50 text-gray-400">Already have an account?</span>
                </div>
            </div>

            <!-- Login Link -->
            <a href="{{ route('login') }}" class="block w-full text-center py-3 border border-white/10 text-white rounded-xl font-semibold hover:bg-white/5 transition">
                Sign in
            </a>
        </div>

        <!-- Back to Home -->
        <a href="{{ route('home') }}" class="flex items-center justify-center mt-6 text-gray-400 hover:text-white text-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to home
        </a>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-sm mt-8">
            &copy; 2024 seeUoNstage. All rights reserved.
        </p>
    </div>

</body>
</html>