<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Status - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
            background-image: 
                radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.15) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.15) 0px, transparent 50%);
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-3xl w-full">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                seeUoNstage
            </h1>
            <p class="text-gray-400 text-lg">Event Organizer Portal</p>
        </div>

        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm rounded-xl p-4 text-green-300 mb-6">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm rounded-xl p-4 text-red-300 mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <!-- Pending Status Card -->
        @if($user->status === 'pending')
        <div class="glass rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="w-24 h-24 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-yellow-500/30">
                    <i class="fas fa-clock text-yellow-400 text-5xl"></i>
                </div>
                
                <h2 class="text-4xl font-bold text-white mb-4">Account Under Review</h2>
                
                <div class="bg-yellow-500/10 border-l-4 border-yellow-500 rounded-r-xl p-6 mb-8 text-left backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-yellow-200 leading-relaxed">
                                <strong class="text-yellow-300">What's happening?</strong><br>
                                Your organizer account registration is currently being reviewed by our admin team.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-300 mb-8 leading-relaxed text-lg">
                    Thank you for your patience, <strong class="text-purple-400">{{ $user->name }}</strong>! 
                    Our team is carefully reviewing your application to ensure the quality and security of our platform. 
                    You will receive a notification once your account has been approved.
                </p>

                <div class="bg-white/5 rounded-xl p-6 mb-8 backdrop-blur-sm border border-white/10">
                    <h3 class="font-bold text-white text-xl mb-4">What happens next?</h3>
                    <ul class="text-left text-gray-300 space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                            <span>Our admin team will review your application within 24-48 hours</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                            <span>You'll receive an email notification about your account status</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                            <span>Once approved, you can start creating and managing events</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-home mr-2"></i>Back to Homepage
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-8 py-4 glass text-white rounded-full font-bold hover:bg-white/10 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Rejected Status Card -->
        @if($user->status === 'rejected')
        <div class="glass rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="w-24 h-24 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-red-500/30">
                    <i class="fas fa-times-circle text-red-400 text-5xl"></i>
                </div>
                
                <h2 class="text-4xl font-bold text-white mb-4">Application Not Approved</h2>
                
                <div class="bg-red-500/10 border-l-4 border-red-500 rounded-r-xl p-6 mb-8 text-left backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-red-200 leading-relaxed">
                                <strong class="text-red-300">Application Status: Rejected</strong><br>
                                Unfortunately, your organizer account application was not approved at this time.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-300 mb-8 leading-relaxed text-lg">
                    We're sorry, <strong class="text-white">{{ $user->name }}</strong>. 
                    Your application to become an event organizer did not meet our current requirements. 
                    This could be due to incomplete information or other verification issues.
                </p>

                <div class="bg-white/5 rounded-xl p-6 mb-8 backdrop-blur-sm border border-white/10">
                    <h3 class="font-bold text-white text-xl mb-4">What are your options?</h3>
                    <ul class="text-left text-gray-300 space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-user text-blue-400 mr-3 mt-1"></i>
                            <span>You can still use the platform as a regular user to browse and book events</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-redo text-green-400 mr-3 mt-1"></i>
                            <span>Contact support for more information about reapplying in the future</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-trash text-red-400 mr-3 mt-1"></i>
                            <span>Delete your account if you no longer wish to use our services</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
                    <a href="{{ route('home') }}" class="px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-home mr-2"></i>Continue as User
                    </a>
                    <form method="POST" action="{{ route('organizer.deleteAccount') }}" 
                          onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 transition shadow-lg">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Account
                        </button>
                    </form>
                </div>

                <p class="text-sm text-gray-400">
                    Need help? <a href="mailto:support@seeuonstage.com" class="text-purple-400 hover:text-purple-300 underline">Contact our support team</a>
                </p>
            </div>
        </div>
        @endif

        <!-- Active Status (shouldn't see this page, but just in case) -->
        @if($user->status === 'active')
        <div class="glass rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="w-24 h-24 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-green-500/30">
                    <i class="fas fa-check-circle text-green-400 text-5xl"></i>
                </div>
                
                <h2 class="text-4xl font-bold text-white mb-4">Account Approved!</h2>
                
                <p class="text-gray-300 mb-8 text-lg">
                    Your organizer account has been approved! You can now access your dashboard.
                </p>

                <a href="{{ route('organizer.dashboard') }}" class="inline-block px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                </a>
            </div>
        </div>
        @endif

        <!-- Decorative elements -->
        <div class="absolute top-20 left-0 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-20 right-0 w-72 h-72 bg-pink-500/10 rounded-full blur-3xl -z-10"></div>
    </div>
</body>
</html>