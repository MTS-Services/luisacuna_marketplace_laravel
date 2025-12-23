<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class PaymentSecurityMiddleware
{
    /**
     * Handle an incoming request for payment endpoints
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Rate limiting - prevent abuse
        $key = 'payment-attempts:' . $request->ip() . ':' . Auth::id();

        if (RateLimiter::tooManyAttempts($key, 10)) { // 10 attempts per minute
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'success' => false,
                'message' => "Too many payment attempts. Please try again in {$seconds} seconds.",
            ], 429);
        }

        RateLimiter::hit($key, 60); // 60 seconds decay

        // 2. Verify user is authenticated
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required.',
            ], 401);
        }

        // 3. Verify user email is verified (if required)
        if (Auth::guard('web')->user()->email_verified_at === null && config('auth.email_verification_required', true)) {
            return response()->json([
                'success' => false,
                'message' => 'Email verification required before making payments.',
            ], 403);
        }

        // 4. Check if user account is active/not suspended
        // if (method_exists(Auth::guard('web')->user(), 'isSuspended') && Auth::guard('web')->user()->isSuspended()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Your account has been suspended. Please contact support.',
        //     ], 403);
        // }

        // 5. Validate CSRF token for state-changing requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            // Laravel automatically handles CSRF, but we can add extra checks
            if (!$request->hasValidSignature() && !$request->session()->token()) {
                Log::warning('Invalid CSRF token in payment request', [
                    'user_id' => Auth::id(),
                    'ip' => $request->ip(),
                ]);
            }
        }

        return $next($request);
    }
}
