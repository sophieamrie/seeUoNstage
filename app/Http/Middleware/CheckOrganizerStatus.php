<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizerStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // If organizer is not active, redirect to pending page
        if ($user && $user->role === 'organizer' && $user->status !== 'active') {
            return redirect()->route('organizer.pending');
        }
        
        return $next($request);
    }
}