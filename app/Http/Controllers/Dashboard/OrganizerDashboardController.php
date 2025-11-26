<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class OrganizerDashboardController extends Controller
{
    public function index(){
        $events = Event::where('organizer_id', auth()->id())->latest()->get();
        return view('dashboard.organizer', compact('events'));
    }
}