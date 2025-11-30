<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - seeUoNstage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Space Grotesk', sans-serif;
            background-image: 
                radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.08) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.08) 0px, transparent 50%);
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800/50 backdrop-blur-sm border-r border-white/10 flex flex-col">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    seeUoNstage
                </h1>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="ml-3 font-medium">Manage Users</span>
                </a>
                
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span class="ml-3 font-medium">Manage Events</span>
                </a>
                
                <a href="{{ route('admin.ticket-types.index') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('admin.ticket-types.*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span class="ml-3 font-medium">Manage Tickets</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-xl transition group {{ request()->routeIs('admin.reports') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3 font-medium">Reports</span>
                </a>
                
                <div class="h-px bg-white/10 my-4"></div>
                
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl transition text-gray-400 hover:text-white hover:bg-white/5 group">
                    <i class="fas fa-arrow-left w-5"></i>
                    <span class="ml-3 font-medium">Back to Website</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="glass rounded-xl p-4 mb-3 border border-white/10">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">Administrator</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full glass hover:bg-white/10 text-white py-2.5 px-4 rounded-xl font-medium transition flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="glass sticky top-0 z-10 border-b border-white/10">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard')</h2>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 backdrop-blur-sm rounded-xl px-4 py-3 mb-6 flex items-center text-green-300">
                    <i class="fas fa-check-circle mr-3 text-green-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm rounded-xl px-4 py-3 mb-6 flex items-center text-red-300">
                    <i class="fas fa-exclamation-circle mr-3 text-red-400"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm rounded-xl px-4 py-3 mb-6 text-red-300">
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