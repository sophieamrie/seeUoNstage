@extends('layouts.organizer')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-3">Organizer Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }} (Organizer)</p>

    <div class="mt-6 p-4 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-2">Event Statistics</h2>
        <p>Coming soon...</p>
    </div>
@endsection
