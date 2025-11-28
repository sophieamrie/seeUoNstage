<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-purple-700 to-purple-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-purple-600">
                <h1 class="text-2xl font-bold">seeUoNstage</h1>
                <p class="text-purple-200 text-sm">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-800 border-l-4 border-white' : 'hover:bg-purple-800' }}">
                    <i class="fas fa-chart-line mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.users.*') ? 'bg-purple-800 border-l-4 border-white' : 'hover:bg-purple-800' }}">
                    <i class="fas fa-users mr-3"></i>
                    Manage Users
                </a>
                
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.events.*') ? 'bg-purple-800 border-l-4 border-white' : 'hover:bg-purple-800' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Manage Events
                </a>
                
                <a href="{{ route('admin.ticket-types.index') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.ticket-types.*') ? 'bg-purple-800 border-l-4 border-white' : 'hover:bg-purple-800' }}">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    Manage Tickets
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.reports') ? 'bg-purple-800 border-l-4 border-white' : 'hover:bg-purple-800' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Reports
                </a>
                
                <hr class="my-4 border-purple-600">
                
                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-home mr-3"></i>
                    Back to Website
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-6 py-3 hover:bg-purple-800 transition w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Welcome back,</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    <p class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>