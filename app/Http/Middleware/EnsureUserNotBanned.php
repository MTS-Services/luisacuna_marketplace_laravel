<?php

namespace App\Http\Middleware;

use App\Enums\UserAccountStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotBanned
{
    /**
     * Handle an incoming request. Log out and redirect banned web guard users.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user && $user->isCurrentlyBanned()) {
                Auth::guard('web')->logout();

                return redirect()
                    ->route('login')
                    ->withErrors(['message' => $user->getBannedLoginMessage()]);
            }
        }

        // No banned web user, continue request
        return $next($request);
    }
}
