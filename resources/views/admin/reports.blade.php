@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Analytics & Reports')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-400">Total Revenue</p>
            <p class="text-xs text-gray-500 mt-2">From approved bookings</p>
        </div>
    </div>

    <!-- Tickets Sold -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ number_format($totalTicketsSold) }}</p>
            <p class="text-sm text-gray-400">Tickets Sold</p>
            <p class="text-xs text-gray-500 mt-2">Total approved tickets</p>
        </div>
    </div>

    <!-- Approved Bookings -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-purple-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $bookingsByStatus['approved'] ?? 0 }}</p>
            <p class="text-sm text-gray-400">Approved Bookings</p>
            <p class="text-xs text-gray-500 mt-2">Successfully processed</p>
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6 relative overflow-hidden group hover:border-purple-500/50 transition">
        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-orange-400 text-xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white mb-1">{{ $bookingsByStatus['pending'] ?? 0 }}</p>
            <p class="text-sm text-gray-400">Pending Bookings</p>
            <p class="text-xs text-gray-500 mt-2">Awaiting approval</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Sales Chart -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Monthly Sales Trend</h3>
        <canvas id="monthlySalesChart"></canvas>
    </div>

    <!-- Booking Status Chart -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Booking Status Distribution</h3>
        <canvas id="bookingStatusChart"></canvas>
    </div>
</div>

<!-- Top Events by Revenue -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl mb-8 overflow-hidden">
    <div class="p-6 border-b border-white/10">
        <h3 class="text-lg font-semibold text-white">Top 10 Events by Revenue</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Rank</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Event Name</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase">Revenue</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase">Performance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($revenueByEvent as $index => $event)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl font-bold
                            {{ $index == 0 ? 'bg-yellow-500/20 text-yellow-400' : ($index == 1 ? 'bg-gray-500/20 text-gray-400' : ($index == 2 ? 'bg-orange-500/20 text-orange-400' : 'bg-purple-500/20 text-purple-400')) }}">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-white">{{ $event->title }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-bold text-green-400">Rp {{ number_format($event->revenue, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">
                            <div class="flex-1 max-w-xs bg-gray-700/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $revenueByEvent->max('revenue') > 0 ? ($event->revenue / $revenueByEvent->max('revenue') * 100) : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm text-gray-400 font-medium min-w-[3rem] text-right">
                                {{ $revenueByEvent->max('revenue') > 0 ? round($event->revenue / $revenueByEvent->max('revenue') * 100) : 0 }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-inbox text-gray-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-400">No revenue data available</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top Events by Bookings -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/10">
        <h3 class="text-lg font-semibold text-white">Top 10 Events by Ticket Sales</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Rank</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Event Name</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase">Tickets Sold</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase">Popularity</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($topEvents as $index => $event)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl font-bold
                            {{ $index == 0 ? 'bg-yellow-500/20 text-yellow-400' : ($index == 1 ? 'bg-gray-500/20 text-gray-400' : ($index == 2 ? 'bg-orange-500/20 text-orange-400' : 'bg-purple-500/20 text-purple-400')) }}">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-white">{{ $event->title }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="font-bold text-blue-400">{{ number_format($event->approved_bookings_count ?? 0) }} tickets</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">
                            <div class="flex-1 max-w-xs bg-gray-700/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $topEvents->max('approved_bookings_count') > 0 ? (($event->approved_bookings_count ?? 0) / $topEvents->max('approved_bookings_count') * 100) : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm text-gray-400 font-medium min-w-[3rem] text-right">
                                {{ $topEvents->max('approved_bookings_count') > 0 ? round(($event->approved_bookings_count ?? 0) / $topEvents->max('approved_bookings_count') * 100) : 0 }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-inbox text-gray-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-400">No booking data available</p>
                        </div>
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
    // Chart.js default colors for dark theme
    Chart.defaults.color = '#9CA3AF';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';

    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlySales->pluck('month')) !!},
            datasets: [{
                label: 'Total Bookings',
                data: {!! json_encode($monthlySales->pluck('total')) !!},
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }, {
                label: 'Revenue (Rp)',
                data: {!! json_encode($monthlySales->pluck('revenue')) !!},
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
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
            plugins: {
                legend: {
                    labels: {
                        color: '#fff',
                        font: {
                            size: 12,
                            family: 'Space Grotesk'
                        },
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Bookings',
                        color: '#9CA3AF'
                    },
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue (Rp)',
                        color: '#9CA3AF'
                    },
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)'
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
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)',
                    'rgb(239, 68, 68)',
                    'rgb(107, 114, 128)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        font: {
                            size: 12,
                            family: 'Space Grotesk'
                        },
                        padding: 15
                    }
                }
            }
        }
    });
</script>
@endsection