<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerPendingController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('dashboard.organizer-pending', compact('user'));
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        
        // Only allow deletion if status is rejected
        if ($user->status === 'rejected') {
            auth()->logout();
            $user->delete();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        }
        
        return redirect()->back()->with('error', 'Cannot delete account.');
    }
}