<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller{
    //list untuk semua organizer yang statusnya pending/approved/reject
    public function index(){
        //hanya tampilkan organizer
        $pendingUsers = User::where('role', 'organizer')
            ->where('status', 'pending')
            ->get();

        $approvedUsers = User::where('role', 'organizer')
            ->where('status', 'approved')
            ->get();
        
        $rejectedUsers = User::where('role', 'organizer')
            ->where('status', 'rejected')
            ->get();

        return view('admin.users.index', compact(
            'pendingUsers',
            'approvedUsers',
            'rejectedUsers'
        ));
    }

    //approve organizer
    public function approve(User $user){
        if ($user->role !== 'organizer'){
            abort(403, 'Not an organizer');
        }

        $user->status = 'approved';
        $user->save();

        return redirect()->back()->with('success', 'Organizer approved.');
    }

    //reject organizer
    public function reject(User $user){
        if ($user->role !== 'organizer'){
            abort(403, 'Not an organizer');
        }

        $user->status = 'rejected';
        $user->save();

        return redirect()->back()->with('success', 'organizer rejected');
    }
}