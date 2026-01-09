<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        if (Auth::guard('web')->check() && $request->routeIs('user.*')) {
            $userId = user()->id;
            User::where('id', $userId)
                ->update([
                    'last_seen_at' => now(),
                    'updated_at' => now()
                ]);

        }
        return $next($request);
    }




    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        // Check if this is an admin route
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }
        // Default to user login
        return route('login');
    }
}
