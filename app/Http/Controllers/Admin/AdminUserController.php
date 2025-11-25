<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        $pendingOrganizers = User::where('role', 'organizer')
                                 ->where('status', 'pending')
                                 ->get();
        
        return view('admin.users.index', compact('users', 'pendingOrganizers'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'active']);
        
        return redirect()->back()->with('success', 'User approved successfully!');
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'User rejected.');
    }
}