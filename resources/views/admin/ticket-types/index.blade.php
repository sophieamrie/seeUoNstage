<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ticket Types - Admin</title>
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
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Manage Events
                </a>
                <a href="{{ route('admin.ticket-types.index') }}" class="flex items-center px-6 py-3 bg-purple-800 border-l-4 border-white">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    Ticket Types
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-purple-800 transition">
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
                    <h2 class="text-2xl font-semibold text-gray-800">Manage Ticket Types</h2>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.ticket-types.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Ticket Type
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

                <!-- Ticket Types Grid -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">All Ticket Types ({{ $ticketTypes->total() }})</h3>
                        <div class="flex space-x-2">
                            <input type="text" placeholder="Search ticket types..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>

                    @if($ticketTypes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Quota</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remaining</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($ticketTypes as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $ticket->name }}</p>
                                            @if($ticket->description)
                                            <p class="text-sm text-gray-500">{{ substr($ticket->description, 0, 50) }}...</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $ticket->event->title }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $ticket->event->organizer->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $ticket->quota }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                            @if($ticket->remaining_quota > 0)
                                                bg-blue-100 text-blue-700
                                            @else
                                                bg-red-100 text-red-700
                                            @endif
                                        ">
                                            {{ $ticket->remaining_quota }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.ticket-types.edit', $ticket) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.ticket-types.destroy', $ticket) }}" onsubmit="return confirm('Are you sure you want to delete this ticket type?');" class="inline">
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
                        {{ $ticketTypes->links() }}
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-ticket-alt text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Ticket Types Yet</h3>
                        <p class="text-gray-600 mb-4">Create your first ticket type to get started</p>
                        <a href="{{ route('admin.ticket-types.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Ticket Type
                        </a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>