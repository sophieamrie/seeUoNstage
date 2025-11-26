<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Status - seeUoNstage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-purple-700">seeUoNstage</h1>
            <p class="text-gray-600 mt-2">Event Organizer Portal</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif

        <!-- Pending Status Card -->
        @if($user->status === 'pending')
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-clock text-yellow-500 text-5xl"></i>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Account Under Review</h2>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>What's happening?</strong><br>
                            Your organizer account registration is currently being reviewed by our admin team.
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-gray-600 mb-8 leading-relaxed">
                Thank you for your patience, <strong class="text-purple-600">{{ $user->name }}</strong>! 
                Our team is carefully reviewing your application to ensure the quality and security of our platform. 
                You will receive a notification once your account has been approved.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-3">What happens next?</h3>
                <ul class="text-left text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span>Our admin team will review your application within 24-48 hours</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span>You'll receive an email notification about your account status</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span>Once approved, you can start creating and managing events</span>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-home mr-2"></i>Back to Homepage
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Rejected Status Card -->
        @if($user->status === 'rejected')
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-times-circle text-red-500 text-5xl"></i>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Application Not Approved</h2>
            
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <strong>Application Status: Rejected</strong><br>
                            Unfortunately, your organizer account application was not approved at this time.
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-gray-600 mb-8 leading-relaxed">
                We're sorry, <strong class="text-gray-800">{{ $user->name }}</strong>. 
                Your application to become an event organizer did not meet our current requirements. 
                This could be due to incomplete information or other verification issues.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-3">What are your options?</h3>
                <ul class="text-left text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-user text-blue-500 mr-2 mt-1"></i>
                        <span>You can still use the platform as a regular user to browse and book events</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-redo text-green-500 mr-2 mt-1"></i>
                        <span>Contact support for more information about reapplying in the future</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-trash text-red-500 mr-2 mt-1"></i>
                        <span>Delete your account if you no longer wish to use our services</span>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-home mr-2"></i>Continue as User
                </a>
                <form method="POST" action="{{ route('organizer.deleteAccount') }}" 
                      onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash-alt mr-2"></i>Delete Account
                    </button>
                </form>
            </div>

            <p class="text-sm text-gray-500 mt-6">
                Need help? <a href="mailto:support@seeuonstage.com" class="text-purple-600 hover:underline">Contact our support team</a>
            </p>
        </div>
        @endif

        <!-- Active Status (shouldn't see this page, but just in case) -->
        @if($user->status === 'active')
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-5xl"></i>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Account Approved!</h2>
            
            <p class="text-gray-600 mb-8">
                Your organizer account has been approved! You can now access your dashboard.
            </p>

            <a href="{{ route('organizer.dashboard') }}" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
            </a>
        </div>
        @endif
    </div>
</body>
</html>