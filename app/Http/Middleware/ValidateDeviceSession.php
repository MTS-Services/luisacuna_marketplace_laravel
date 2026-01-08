<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ValidateDeviceSession
{
    /**
     * Grace period in seconds for new logins to register device.
     */
    protected int $gracePeriod = 30;

    /**
     * Routes that should be excluded from device validation.
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
        'logout', // Add logout to prevent issues
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        if (!$guard) {
            $guard = $this->detectAuthGuard($request);
        }
        // Skip validation for excluded routes
        if ($this->shouldSkipValidation($request)) {
            Log::debug('Skipping validation', ['route' => $request->route()?->getName()]);
            return $next($request);
        }

        // Skip if device registration is pending
        if (session()->has('device_registration_pending')) {
            Log::debug('Device registration pending');
            return $next($request);
        }

        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            // Get current device
            $device = $user->getCurrentDevice();

            // Log the check
            Log::debug('Middleware check', [
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'device_id' => $device?->id,
                'device_active' => $device?->is_active,
                'route' => $request->route()?->getName(),
                'within_grace' => $this->isWithinGracePeriod($user),
            ]);

            // Allow grace period ONLY if device is active
            if ($device && $device->is_active && $this->isWithinGracePeriod($user)) {
                Log::debug('Within grace period and device active');
                return $next($request);
            }

            // Check device validity
            $isValid = $this->isDeviceValid($user, $device);

            // If device is invalid, FORCE LOGOUT
            if (!$isValid) {
                $reason = $this->getLogoutReason($user, $device);

                Log::warning('Device session invalid - FORCING LOGOUT NOW', [
                    'user_id' => $user->id,
                    'session_id' => session()->getId(),
                    'device_id' => $device?->id,
                    'device_active' => $device?->is_active ?? 'no_device',
                    'reason' => $reason,
                    'route' => $request->route()?->getName(),
                    'url' => $request->url(),
                ]);

                // FORCE COMPLETE LOGOUT
                return $this->forceLogout($request, $guard, $reason);
            }

            // Update device last_used_at (only if valid)
            if ($device && $device->is_active) {
                $device->updateQuietly(['last_used_at' => now()]);
            }
        }

        return $next($request);
    }

    /**
     * Detect which guard the user is authenticated with.
     */
    protected function detectAuthGuard(Request $request): string
    {
        // Check if authenticated as admin first
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check if authenticated as regular user
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        // Check route patterns to determine intended guard
        $routeName = $request->route()?->getName();
        if ($routeName && str_starts_with($routeName, 'admin.')) {
            return 'admin';
        }

        // Check URL path
        if ($request->is('admin/*') || $request->is('admin')) {
            return 'admin';
        }

        // Default to web
        return 'web';
    }
    /**
     * Check if device is valid.
     */
    protected function isDeviceValid($user, $device): bool
    {
        // No device found - invalid
        if (!$device) {
            Log::warning('No device found for session');
            return false;
        }

        // Device is inactive - invalid
        if (!$device->is_active) {
            Log::warning('Device is inactive', ['device_id' => $device->id]);
            return false;
        }

        // Check if all devices were logged out after this device was created
        if (
            $user->all_devices_logged_out_at &&
            $device->created_at < $user->all_devices_logged_out_at
        ) {
            Log::warning('All devices logged out', [
                'device_created' => $device->created_at,
                'all_logged_out_at' => $user->all_devices_logged_out_at,
            ]);
            return false;
        }

        return true;
    }

    /**
     * Force complete logout from everywhere.
     */
    protected function forceLogout(Request $request, string $guard, string $reason): Response
    {
        $sessionId = session()->getId();

        Log::info('Starting force logout process', [
            'session_id' => $sessionId,
            'reason' => $reason,
        ]);

        // 1. Logout from Laravel Auth
        Auth::guard($guard)->logout();

        // 2. Delete session from Redis manually
        try {
            $redisKey = config('cache.prefix') ?
                config('cache.prefix') . ':' . $sessionId :
                $sessionId;

            // Try different possible Redis key formats
            $possibleKeys = [
                'laravel_session:' . $sessionId,
                'laravel_database_' . $sessionId,
                'laravel_cache_' . $sessionId,
                $sessionId,
                $redisKey,
            ];

            foreach ($possibleKeys as $key) {
                if (Redis::exists($key)) {
                    Redis::del($key);
                    Log::info('Deleted Redis session key', ['key' => $key]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete Redis session', [
                'error' => $e->getMessage(),
                'session_id' => $sessionId,
            ]);
        }

        // 3. Invalidate Laravel session
        $request->session()->invalidate();

        // 4. Regenerate CSRF token
        $request->session()->regenerateToken();

        // 5. Flush all session data
        $request->session()->flush();

        // 6. Clear session cookie from browser
        cookie()->queue(cookie()->forget(session()->getName()));

        Log::info('Force logout completed', ['reason' => $reason]);

        // Return appropriate response based on request type
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Your session has been terminated. Please login again.',
                'reason' => $reason,
                'redirect' => route($guard === 'admin' ? 'admin.login' : 'login'),
                'force_reload' => true,
            ], 401);
        }

        // For Livewire requests - return 401 to trigger frontend handling
        if ($request->header('X-Livewire')) {
            return response([
                'message' => 'Session terminated',
                'reason' => $reason,
            ], 401)
                ->header('X-Livewire-Redirect', route($guard === 'admin' ? 'admin.login' : 'login'));
        }

        // Regular web request - redirect with message
        return redirect()
            ->route($guard === 'admin' ? 'admin.login' : 'login')
            ->with('error', 'Your session has been terminated. Please login again.')
            ->with('logout_reason', $reason)
            ->withCookie(cookie()->forget(session()->getName()));
    }

    /**
     * Get the reason for logout.
     */
    protected function getLogoutReason($user, $device): string
    {
        if (!$device) {
            return 'device_not_found';
        }

        if (!$device->is_active) {
            return 'device_logged_out';
        }

        if (
            $user->all_devices_logged_out_at &&
            $device->created_at < $user->all_devices_logged_out_at
        ) {
            return 'all_devices_logged_out';
        }

        return 'unknown';
    }

    /**
     * Determine if the request should skip device validation.
     */
    protected function shouldSkipValidation(Request $request): bool
    {
        // Skip for excluded routes
        foreach ($this->excludedRoutes as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }

        // Skip for Livewire login/register components
        if ($request->header('X-Livewire')) {
            $livewireComponent = $request->input('components.0.snapshot.memo.name', '');

            $excludedComponents = ['login', 'register', 'two-factor', 'password', 'verification'];

            foreach ($excludedComponents as $component) {
                if (str_contains(strtolower($livewireComponent), $component)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if user is within grace period after login.
     */
    protected function isWithinGracePeriod($user): bool
    {
        if (!$user->last_login_at) {
            return false;
        }

        $secondsSinceLogin = now()->diffInSeconds($user->last_login_at);

        return $secondsSinceLogin <= $this->gracePeriod;
    }
}
