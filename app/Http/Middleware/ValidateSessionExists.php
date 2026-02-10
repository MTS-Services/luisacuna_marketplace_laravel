<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ValidateSessionExists
{
    /**
     * Routes that should be excluded from session validation
     */
    protected array $excludedRoutes = [
        'login',
        'register',
        'register.*',
        'two-factor.*',
        'password.*',
        'verification.*',
        'admin.login',
        'admin.register',
        'logout',
    ];

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip validation for excluded routes
        if ($this->shouldSkipValidation($request)) {
            return $next($request);
        }

        // Detect guard
        $guard = $this->detectAuthGuard($request);

        if (Auth::guard($guard)->check()) {
            $sessionId = Session::getId();
            $userId = Auth::guard($guard)->id();

            // Check if session exists in database
            $exists = DB::table(config('session.table', 'sessions'))
                ->where('id', $sessionId)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                // Session was deleted (logged out from another device)
                Auth::guard($guard)->logout();
                Session::invalidate();
                Session::regenerateToken();

                if ($request->expectsJson() || $request->wantsJson()) {
                    return response()->json([
                        'message' => 'Your session has been terminated.',
                        'redirect' => route($guard === 'admin' ? 'admin.login' : 'login'),
                    ], 401);
                }

                return redirect()
                    ->route($guard === 'admin' ? 'admin.login' : 'login')
                    ->with('error', 'You have been logged out from another device.');
            }
        }

        return $next($request);
    }

    /**
     * Detect which guard the user is authenticated with
     */
    protected function detectAuthGuard(Request $request): string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (Auth::guard('web')->check()) {
            return 'web';
        }

        $routeName = $request->route()?->getName();
        if ($routeName && str_starts_with($routeName, 'admin.')) {
            return 'admin';
        }

        if ($request->is('admin/*') || $request->is('admin')) {
            return 'admin';
        }

        return 'web';
    }

    /**
     * Determine if the request should skip validation
     */
    protected function shouldSkipValidation(Request $request): bool
    {
        foreach ($this->excludedRoutes as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }

        return false;
    }
}