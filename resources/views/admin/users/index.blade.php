@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Organizer Approval Management</h1>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    {{-- Pending Organizers --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <strong>Pending Organizers</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($pendingUsers as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">No pending organizers</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- Approved Organizers --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <strong>Approved Organizers</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($approvedUsers as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-success">Approved</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3">No approved organizers</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- Rejected Organizers (Optional) --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <strong>Rejected Organizers</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($rejectedUsers as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-danger">Rejected</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3">No rejected organizers</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
