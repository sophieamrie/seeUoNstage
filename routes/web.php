<?php

use Illuminate\Support\Facades\Route;

//PUBLIC CONTROLLERS
use App\Http\Controllers\EventCatalogController;

// DASHBOARD CONTROLLERS
use App\Models\Event;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\OrganizerDashboardController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Dashboard\OrganizerPendingController;

// USER CONTROLLERS
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\FavoriteController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminTicketController;

// ORGANIZER CONTROLLERS
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\TicketTypeController;
use App\Http\Controllers\Organizer\BookingApprovalController;

// PROFILE CONTROLLER
use App\Http\Controllers\ProfileController;


// =============================
// PUBLIC ROUTES
// =============================
Route::get('/', function () {
    return view('welcome', [
        'latestEvents' => Event::latest()->take(6)->get(),
        'popularEvents' => Event::orderBy('views', 'desc')->take(6)->get(),
    ]);
})->name('home');

Route::get('/events', [EventCatalogController::class, 'index'])->name('events.index');

// Update this to use the controller
Route::get('/events/{event}', [EventCatalogController::class, 'show'])->name('events.show');


// =============================
// USER DASHBOARD
// =============================
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // USER BOOKINGS
    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    // USER FAVORITES
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('favorites.index');

    Route::post('/favorites/{event}/toggle', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
});


// =============================
// ORGANIZER ROUTES - PENDING PAGE (No status check)
// =============================
Route::middleware(['auth', 'role:organizer'])->group(function () {
    
    // Pending page - accessible to all organizers regardless of status
    Route::get('/organizer/pending', [OrganizerPendingController::class, 'index'])
        ->name('organizer.pending');

    // Delete account - only for rejected organizers
    Route::post('/organizer/delete-account', [OrganizerPendingController::class, 'deleteAccount'])
        ->name('organizer.deleteAccount');
});


// =============================
// ORGANIZER ROUTES - ACTIVE ONLY (With status check)
// =============================
Route::middleware(['auth', 'role:organizer', 'organizer.status'])->group(function () {

    // Dashboard
    Route::get('/organizer/dashboard', [OrganizerDashboardController::class, 'index'])
        ->name('organizer.dashboard');

    // EVENT CRUD
    Route::resource('/organizer/events', OrganizerEventController::class)->names([
        'index' => 'organizer.events.index',
        'create' => 'organizer.events.create',
        'store' => 'organizer.events.store',
        'show' => 'organizer.events.show',
        'edit' => 'organizer.events.edit',
        'update' => 'organizer.events.update',
        'destroy' => 'organizer.events.destroy',
    ]);

    // TICKET TYPE CRUD
    Route::resource('/organizer/ticket-types', TicketTypeController::class)->names([
        'index' => 'organizer.ticket-types.index',
        'create' => 'organizer.ticket-types.create',
        'store' => 'organizer.ticket-types.store',
        'show' => 'organizer.ticket-types.show',
        'edit' => 'organizer.ticket-types.edit',
        'update' => 'organizer.ticket-types.update',
        'destroy' => 'organizer.ticket-types.destroy',
    ]);

    // BOOKING APPROVAL
    Route::get('/organizer/bookings', [BookingApprovalController::class, 'index'])
        ->name('organizer.bookings.index');

    Route::post('/organizer/bookings/{booking}/approve',
        [BookingApprovalController::class, 'approve'])
        ->name('organizer.bookings.approve');

    Route::post('/organizer/bookings/{booking}/reject',
        [BookingApprovalController::class, 'reject'])
        ->name('organizer.bookings.reject');
});


// =============================
// ADMIN ROUTES
// =============================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Reports
    Route::get('/admin/reports', [AdminDashboardController::class, 'reports'])
        ->name('admin.reports');

    // USER APPROVAL
    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/admin/users/{user}/approve', [AdminUserController::class, 'approve'])
        ->name('admin.users.approve');

    Route::post('/admin/users/{user}/reject', [AdminUserController::class, 'reject'])
        ->name('admin.users.reject');

    // EVENT CRUD
    Route::resource('/admin/events', AdminEventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'show' => 'admin.events.show',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);

    // Back to website (logout and redirect)
    Route::post('/admin/back-to-website', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('admin.backToWebsite');

    // TICKET TYPES CRUD (Admin)
    Route::resource('/admin/ticket-types', AdminTicketController::class)->names([
        'index' => 'admin.ticket-types.index',
        'create' => 'admin.ticket-types.create',
        'store' => 'admin.ticket-types.store',
        'edit' => 'admin.ticket-types.edit',
        'update' => 'admin.ticket-types.update',
        'destroy' => 'admin.ticket-types.destroy',
    ]);
});


// =============================
// PROFILE ROUTES (Laravel Breeze default)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// =============================
// AUTH ROUTES
// =============================
require __DIR__.'/auth.php';