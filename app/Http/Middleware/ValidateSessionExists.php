<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ValidateSessionExists
{
    /**
     * Grace period in seconds for new sessions to be written to database
     */
    protected int $gracePeriod = 5;

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
        'verify-otp',
        'admin.login',
        'admin.register',
        'admin.two-factor.*',
        'admin.password.*',
        'admin.verification.*',
        'admin.verify-otp',
        'logout',
        'admin.logout',
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

            // Check if this is a newly created session (within grace period)
            if ($this->isWithinGracePeriod($guard)) {
                Log::debug('Session within grace period', [
                    'guard' => $guard,
                    'session_id' => $sessionId
                ]);
                return $next($request);
            }

            // Check if session exists in database
            $exists = DB::table(config('session.table', 'sessions'))
                ->where('id', $sessionId)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                Log::warning('Session does not exist in database - forcing logout', [
                    'guard' => $guard,
                    'user_id' => $userId,
                    'session_id' => $sessionId
                ]);

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

                // Handle Livewire requests
                if ($request->header('X-Livewire')) {
                    return response([
                        'message' => 'Session terminated',
                    ], 401)
                        ->header('X-Livewire-Redirect', route($guard === 'admin' ? 'admin.login' : 'login'));
                }

                return redirect()
                    ->route($guard === 'admin' ? 'admin.login' : 'login')
                    ->with('error', 'You have been logged out from another device.');
            }
        }

        return $next($request);
    }

    /**
     * Check if user session is within grace period after login
     */
    protected function isWithinGracePeriod(string $guard): bool
    {
        $user = Auth::guard($guard)->user();

        if (!$user) {
            return false;
        }

        // Check if user has last_login_at column
        if (!isset($user->last_login_at)) {
            return false;
        }

        $lastLogin = $user->last_login_at;

        if (!$lastLogin) {
            return false;
        }

        $secondsSinceLogin = now()->diffInSeconds($lastLogin);

        return $secondsSinceLogin <= $this->gracePeriod;
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
