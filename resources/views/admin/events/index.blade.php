<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-purple-700 to-purple-900 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold">seeUoNstage</h1>
                <p class="text-purple-200 text-sm">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-chart-line mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-users mr-3"></i>
                    Manage Users
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 bg-purple-800 border-l-4 border-white">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Manage Events
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Reports
                </a>
                <hr class="my-4 border-purple-600">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ route('home') }}">
                    <button type="submit" class="flex items-center px-6 py-3 hover:bg-purple-800 transition w-full text-left">
                        <i class="fas fa-home mr-3"></i>
                        Back to Website
                    </button>
                </form>
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
                    <h2 class="text-2xl font-semibold text-gray-800">Manage Events</h2>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Event
                        </a>
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

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                <!-- Events Grid -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">All Events ({{ $events->total() }})</h3>
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Search events..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>

                    @if($events->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($events as $event)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            @if($event->image_url)
                                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-white text-xl"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                                                @if($event->artist)
                                                <p class="text-sm text-gray-500">{{ $event->artist }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($event->category)
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">{{ $event->category }}</span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $event->organizer->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-800 font-medium">{{ $event->start_datetime->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $event->start_datetime->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                        {{ $event->location }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($event->is_published)
                                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>Published
                                        </span>
                                        @else
                                        <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                            <i class="fas fa-eye-slash mr-1"></i>Draft
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-6 border-t">
                        {{ $events->links() }}
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-alt text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Events Yet</h3>
                        <p class="text-gray-600 mb-4">Get started by creating your first event</p>
                        <a href="{{ route('admin.events.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Event
                        </a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>