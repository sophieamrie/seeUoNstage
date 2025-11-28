<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalEvents' => Event::count(),
            'totalBookings' => Booking::count(),
            'pendingOrganizers' => User::where('role', 'organizer')
                                      ->where('status', 'pending')
                                      ->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentEvents' => Event::latest()->take(5)->get(),
        ];

        return view('dashboard.admin', $data);
    }

    public function reports()
    {
        // Get ticket sales data - FIX: specify table name for ambiguous status column
        $totalRevenue = Booking::where('bookings.status', 'approved')
            ->join('ticket_types', 'bookings.ticket_type_id', '=', 'ticket_types.id')
            ->sum(DB::raw('bookings.quantity * ticket_types.price'));
        
        $totalTicketsSold = Booking::where('status', 'approved')
            ->sum('quantity');
        
        // Get bookings by status
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        
        // Get top events by bookings - FIX: use proper relationship
        $topEvents = Event::withCount(['bookings as approved_bookings_count' => function($query) {
                $query->where('bookings.status', 'approved');
            }])
            ->withSum(['bookings as total_tickets_sold' => function($query) {
                $query->where('bookings.status', 'approved');
            }], 'quantity')
            ->orderBy('approved_bookings_count', 'desc')
            ->take(10)
            ->get();
        
        // Get revenue by event - FIX: specify bookings.status to avoid ambiguity
        $revenueByEvent = Event::leftJoin('ticket_types', 'events.id', '=', 'ticket_types.event_id')
            ->leftJoin('bookings', function($join) {
                $join->on('ticket_types.id', '=', 'bookings.ticket_type_id')
                    ->where('bookings.status', '=', 'approved');
            })
            ->select('events.id', 'events.title', DB::raw('COALESCE(SUM(bookings.quantity * ticket_types.price), 0) as revenue'))
            ->groupBy('events.id', 'events.title')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();
        
        // Monthly sales data (last 6 months)
        $monthlySales = Booking::where('status', 'approved')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent bookings for reports page
        $recentBookings = Booking::with(['user', 'event', 'ticketType'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports', compact(
            'totalRevenue',
            'totalTicketsSold',
            'bookingsByStatus',
            'topEvents',
            'revenueByEvent',
            'monthlySales',
            'recentBookings'
        ));
    }
}