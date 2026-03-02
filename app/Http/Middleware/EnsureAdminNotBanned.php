<?php

namespace App\Http\Middleware;

use App\Enums\AdminStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminNotBanned
{
    /**
     * Handle an incoming request. Log out and redirect banned admin guard users.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            if ($admin && $admin->status === AdminStatus::SUSPENDED) {
                Auth::guard('admin')->logout();

                $message = __('Your account has been banned. You have been logged out.');

                return redirect()
                    ->route('admin.login')
                    ->withErrors(['message' => $message]);
            }
        }

        return $next($request);
    }
}
