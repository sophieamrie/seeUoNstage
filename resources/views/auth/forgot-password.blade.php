<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-purple-600 via-pink-500 to-purple-700 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <h1 class="text-4xl font-bold text-white mb-2">seeUoNstage</h1>
                <p class="text-purple-100">Reset your password</p>
            </a>
        </div>

        <!-- Forgot Password Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-key text-purple-600 text-2xl"></i>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-3 text-center">Forgot Password?</h2>
            
            <p class="text-gray-600 text-center mb-6">
                No problem! Just enter your email address and we'll send you a password reset link.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-purple-600 mr-2"></i>Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition transform hover:scale-[1.02] shadow-lg"
                >
                    <i class="fas fa-paper-plane mr-2"></i>Email Password Reset Link
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">or</span>
                </div>
            </div>

            <!-- Back to Login -->
            <a href="{{ route('login') }}" class="block w-full text-center py-3 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back to Login
            </a>

            <!-- Back to Home -->
            <a href="{{ route('home') }}" class="block text-center mt-4 text-gray-600 hover:text-purple-600 text-sm">
                <i class="fas fa-home mr-1"></i>Back to Home
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-white text-sm mt-6">
            &copy; 2024 seeUoNstage. All rights reserved.
        </p>
    </div>

</body>
</html>