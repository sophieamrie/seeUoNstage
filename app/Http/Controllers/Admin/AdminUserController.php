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

    public function destroy(User $user)
    {
        // Prevent deleting admins or organizers
        if ($user->role === 'admin' || $user->role === 'organizer') {
            return back()->with('error', 'Cannot delete admin or organizer accounts.');
        }
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return back()->with('success', 'User deleted successfully.');
    }
    }