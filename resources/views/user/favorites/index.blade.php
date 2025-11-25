@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2>Favorite Events</h2>
    <p class="text-muted">Acara yang Anda simpan.</p>

    {{-- Future list of favorite events --}}
    <div class="alert alert-info">
        Belum ada event favorit.
    </div>
</div>
@endsection
