<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\OrganizerDashboardController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Dashboard\OrganizerPendingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'role:user'])
    ->name('dashboard');

Route::get('/organizer/dashboard', [OrganizerDashboardController::class, 'index'])
    ->middleware(['auth', 'role:organizer'])
    ->name('organizer.dashboard');

Route::get('/organizer/pending', [OrganizerPendingController::class, 'index'])
    ->middleware(['auth', 'role:organizer'])
    ->name('organizer.pending');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::middleware(['auth', 'role:admin'])->group(function (){

    Route::get('/admin/users',
        [\App\Http\Controllers\Admin\AdminUserController::class, 'index']
    )->name('admin.users.index');

    Route::post('/admin/users/{user}/approve',
        [\App\Http\Controllers\Admin\AdminUserController::class, 'approve']
        )->name('admin.users.approve');

    Route::post('/admin/users/{user}/reject',
        [\App\Http\Controllers\Admin\AdminUserController::class, 'reject']
        )->name('admin.users.reject');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
