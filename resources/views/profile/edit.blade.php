@extends('layouts.user')

@section('title', 'Profile')

@section('content')
<div class="container py-4">

    <h2 class="mb-3">Edit Profile</h2>

    @include('profile.partials.update-profile-information-form')

    <hr class="my-4">

    @include('profile.partials.update-password-form')

    <hr class="my-4">

    @include('profile.partials.delete-user-form')

</div>
@endsection
