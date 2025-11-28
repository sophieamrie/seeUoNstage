@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Sales & Analytics Reports')

@section('content')
<!-- Print Button in header would go in a custom section, but for now we'll put it in content -->
<div class="flex justify-end mb-6">
    <button onclick="window.print()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
        <i class="fas fa-print mr-2"></i>Print Report
    </button>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Total Revenue</h3>
            <i class="fas fa-dollar-sign text-2xl opacity-80"></i>
        </div>
        <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-xs opacity-80 mt-2">From approved bookings</p>
    </div>

    <!-- Tickets Sold -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Tickets Sold</h3>
            <i class="fas fa-ticket-alt text-2xl opacity-80"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($totalTicketsSold) }}</p>
        <p class="text-xs opacity-80 mt-2">Total approved tickets</p>
    </div>

    <!-- Approved Bookings -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Approved Bookings</h3>
            <i class="fas fa-check-circle text-2xl opacity-80"></i>
        </div>
        <p class="text-3xl font-bold">{{ $bookingsByStatus['approved'] ?? 0 }}</p>
        <p class="text-xs opacity-80 mt-2">Successfully processed</p>
    </div>

    <!-- Pending Bookings -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium opacity-90">Pending Bookings</h3>
            <i class="fas fa-clock text-2xl opacity-80"></i>
        </div>
        <p class="text-3xl font-bold">{{ $bookingsByStatus['pending'] ?? 0 }}</p>
        <p class="text-xs opacity-80 mt-2">Awaiting approval</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Sales Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Sales Trend (Last 6 Months)</h3>
        <canvas id="monthlySalesChart"></canvas>
    </div>

    <!-- Booking Status Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Status Distribution</h3>
        <canvas id="bookingStatusChart"></canvas>
    </div>
</div>

<!-- Top Events by Revenue -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Top 10 Events by Revenue</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Performance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($revenueByEvent as $index => $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                            {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : ($index == 1 ? 'bg-gray-100 text-gray-700' : ($index == 2 ? 'bg-orange-100 text-orange-700' : 'bg-blue-50 text-blue-600')) }} font-bold">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-bold text-green-600">Rp {{ number_format($event->revenue, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full" 
                                     style="width: {{ $revenueByEvent->max('revenue') > 0 ? ($event->revenue / $revenueByEvent->max('revenue') * 100) : 0 }}%">
                                </div>
                            </div>
                            <span class="text-xs text-gray-600">
                                {{ $revenueByEvent->max('revenue') > 0 ? round($event->revenue / $revenueByEvent->max('revenue') * 100) : 0 }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>No revenue data available</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top Events by Bookings -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Top 10 Events by Ticket Sales</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tickets Sold</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Popularity</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($topEvents as $index => $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                            {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : ($index == 1 ? 'bg-gray-100 text-gray-700' : ($index == 2 ? 'bg-orange-100 text-orange-700' : 'bg-blue-50 text-blue-600')) }} font-bold">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">{{ $event->title }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-bold text-blue-600">{{ number_format($event->approved_bookings_count ?? 0) }} tickets</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" 
                                     style="width: {{ $topEvents->max('approved_bookings_count') > 0 ? (($event->approved_bookings_count ?? 0) / $topEvents->max('approved_bookings_count') * 100) : 0 }}%">
                                </div>
                            </div>
                            <span class="text-xs text-gray-600">
                                {{ $topEvents->max('approved_bookings_count') > 0 ? round(($event->approved_bookings_count ?? 0) / $topEvents->max('approved_bookings_count') * 100) : 0 }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>No booking data available</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlySales->pluck('month')) !!},
            datasets: [{
                label: 'Total Bookings',
                data: {!! json_encode($monthlySales->pluck('total')) !!},
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Revenue (Rp)',
                data: {!! json_encode($monthlySales->pluck('revenue')) !!},
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Bookings'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue (Rp)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Booking Status Chart
    const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
    new Chart(bookingStatusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($bookingsByStatus->keys()) !!},
            datasets: [{
                data: {!! json_encode($bookingsByStatus->values()) !!},
                backgroundColor: [
                    'rgb(34, 197, 94)',   // approved - green
                    'rgb(251, 146, 60)',  // pending - orange
                    'rgb(239, 68, 68)',   // rejected - red
                    'rgb(156, 163, 175)'  // cancelled - gray
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection