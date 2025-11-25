@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2>Booking History</h2>
    <p class="text-muted">Daftar pemesanan tiket Anda.</p>

    {{-- Future table of bookings --}}
    <div class="alert alert-info">
        Belum ada data booking.
    </div>
</div>
@endsection
