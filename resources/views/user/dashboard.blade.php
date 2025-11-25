@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="container">

    <h2 class="fw-bold">Welcome, {{ auth()->user()->name }} 👋</h2>
    <p class="text-muted">Here is your user dashboard.</p>

    <div class="row mt-4 g-4">

        {{-- Booking History --}}
        <div class="col-md-4">
            <a href="{{ route('bookings.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>📅 Booking History</h4>
                    <p class="text-muted">Lihat semua pemesanan tiket Anda.</p>
                </div>
            </a>
        </div>

        {{-- Favorites --}}
        <div class="col-md-4">
            <a href="{{ route('favorites.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>⭐ Favorite Events</h4>
                    <p class="text-muted">Acara yang Anda simpan.</p>
                </div>
            </a>
        </div>

        {{-- Profile --}}
        <div class="col-md-4">
            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>👤 Profile</h4>
                    <p class="text-muted">Kelola akun Anda.</p>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
