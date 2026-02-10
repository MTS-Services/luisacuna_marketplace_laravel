<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackUserSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Store user ID in session for tracking
            session(['auth_user_id' => Auth::id()]);
            session(['auth_guard' => 'web']); // or determine dynamically
        }

        return $next($request);
    }
}
