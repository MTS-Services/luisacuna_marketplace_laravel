<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionManager
{
    /**
     * Detect which guard the user is authenticated with
     */
    protected function detectAuthGuard(): ?string
    {
        // Check if authenticated as admin first
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check if authenticated as regular user
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null;
    }

    /**
     * Get authenticated user and guard
     */
    protected function getAuthenticatedUser(): ?array
    {
        $guard = $this->detectAuthGuard();
        
        if (!$guard) {
            return null;
        }

        $user = Auth::guard($guard)->user();
        
        if (!$user) {
            return null;
        }

        return [
            'user' => $user,
            'guard' => $guard
        ];
    }

    /**
     * Logout from all other devices except current
     */
    public function logoutOtherDevices(?string $guard = null): int
    {
        // Auto-detect guard if not provided
        if (!$guard) {
            $authData = $this->getAuthenticatedUser();
            if (!$authData) {
                Log::warning('No authenticated user found for logout');
                return 0;
            }
            $user = $authData['user'];
            $guard = $authData['guard'];
        } else {
            $user = Auth::guard($guard)->user();
            if (!$user) {
                return 0;
            }
        }

        $currentSessionId = Session::getId();
        
        // Delete from database sessions
        $deleted = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();
        
        // Also clear any matching Redis cache entries
        $this->clearRedisSessionCache($user->id, $currentSessionId, $guard);
        
        Log::info('Logged out from other devices', [
            'user_id' => $user->id,
            'guard' => $guard,
            'sessions_deleted' => $deleted,
            'current_session' => $currentSessionId
        ]);
        
        // Regenerate current session
        Session::migrate(true);
        
        return $deleted;
    }

    /**
     * Logout from ALL devices including current
     */
    public function logoutAllDevices(?string $guard = null): int
    {
        // Auto-detect guard if not provided
        if (!$guard) {
            $authData = $this->getAuthenticatedUser();
            if (!$authData) {
                Log::warning('No authenticated user found for logout');
                return 0;
            }
            $user = $authData['user'];
            $guard = $authData['guard'];
        } else {
            $user = Auth::guard($guard)->user();
            if (!$user) {
                return 0;
            }
        }

        // Delete all sessions from database
        $deleted = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $user->id)
            ->delete();
        
        // Clear all Redis cache entries for this user
        $this->clearRedisSessionCache($user->id, null, $guard);
        
        Log::info('Logged out from all devices', [
            'user_id' => $user->id,
            'guard' => $guard,
            'sessions_deleted' => $deleted
        ]);
        
        // Logout current session
        Auth::guard($guard)->logout();
        Session::invalidate();
        Session::regenerateToken();
        
        return $deleted;
    }

    /**
     * Clear Redis session cache for user
     */
    protected function clearRedisSessionCache(int $userId, ?string $currentSessionId = null, string $guard = 'web'): void
    {
        try {
            $allKeys = Redis::keys('laravel_database_laravel_cache_*');
            
            foreach ($allKeys as $redisKey) {
                // Extract cache key (remove database prefix)
                $cacheKey = str_replace('laravel_database_', '', $redisKey);
                $sessionData = Redis::get($cacheKey);
                
                if (!$sessionData) {
                    continue;
                }
                
                // Unserialize twice (outer string, then inner array)
                $serialized = @unserialize($sessionData);
                if ($serialized === false) {
                    continue;
                }
                
                $data = @unserialize($serialized);
                if (!is_array($data)) {
                    continue;
                }
                
                // Check if this session belongs to the user for this guard
                $loginKey = "login_{$guard}_{$userId}";
                $hasAuth = isset($data[$loginKey]) && $data[$loginKey] == $userId;
                
                if ($hasAuth) {
                    // Extract session ID from Redis key
                    $sessionId = str_replace('laravel_database_laravel_cache_', '', $redisKey);
                    
                    // Delete if not current session (or delete all if currentSessionId is null)
                    if ($currentSessionId === null || $sessionId !== $currentSessionId) {
                        Redis::del($cacheKey);
                        
                        Log::info('Cleared Redis session cache', [
                            'guard' => $guard,
                            'user_id' => $userId,
                            'session_id' => $sessionId,
                            'cache_key' => $cacheKey
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error clearing Redis session cache', [
                'guard' => $guard,
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get active sessions count for user
     */
    public function getActiveSessionsCount(?int $userId = null, ?string $guard = null): int
    {
        // Auto-detect if not provided
        if (!$userId || !$guard) {
            $authData = $this->getAuthenticatedUser();
            if (!$authData) {
                return 0;
            }
            $userId = $authData['user']->id;
            $guard = $authData['guard'];
        }

        return DB::table(config('session.table', 'sessions'))
            ->where('user_id', $userId)
            ->count();
    }

    /**
     * Get all active sessions with details for user
     */
    public function getActiveSessions(?int $userId = null, ?string $guard = null): array
    {
        // Auto-detect if not provided
        if (!$userId || !$guard) {
            $authData = $this->getAuthenticatedUser();
            if (!$authData) {
                return [];
            }
            $userId = $authData['user']->id;
            $guard = $authData['guard'];
        }

        $sessions = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $userId)
            ->orderBy('last_activity', 'desc')
            ->get();
        
        $currentSessionId = Session::getId();
        
        return $sessions->map(function ($session) use ($currentSessionId, $guard) {
            // Parse user agent if package is available
            $deviceInfo = $this->parseUserAgent($session->user_agent);
            
            return [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'device' => $deviceInfo['device'],
                'platform' => $deviceInfo['platform'],
                'browser' => $deviceInfo['browser'],
                'last_activity' => $session->last_activity,
                'last_activity_human' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'is_current' => $session->id === $currentSessionId,
                'guard' => $guard,
            ];
        })->toArray();
    }

    /**
     * Parse user agent string
     */
    protected function parseUserAgent(string $userAgent): array
    {
        // Check if jenssegers/agent package is available
        if (class_exists(\Jenssegers\Agent\Agent::class)) {
            $agent = new \Jenssegers\Agent\Agent();
            $agent->setUserAgent($userAgent);
            
            return [
                'device' => $agent->device() ?: 'Unknown Device',
                'platform' => $agent->platform() ?: 'Unknown OS',
                'browser' => $agent->browser() ?: 'Unknown Browser',
            ];
        }
        
        // Fallback to basic parsing
        return [
            'device' => $this->extractDevice($userAgent),
            'platform' => $this->extractPlatform($userAgent),
            'browser' => $this->extractBrowser($userAgent),
        ];
    }

    /**
     * Extract device from user agent (fallback)
     */
    protected function extractDevice(string $userAgent): string
    {
        if (stripos($userAgent, 'Mobile') !== false || stripos($userAgent, 'Android') !== false) {
            return 'Mobile';
        }
        if (stripos($userAgent, 'Tablet') !== false || stripos($userAgent, 'iPad') !== false) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    /**
     * Extract platform from user agent (fallback)
     */
    protected function extractPlatform(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac OS') !== false) return 'macOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iOS') !== false || stripos($userAgent, 'iPhone') !== false) return 'iOS';
        return 'Unknown';
    }

    /**
     * Extract browser from user agent (fallback)
     */
    protected function extractBrowser(string $userAgent): string
    {
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';
        if (stripos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }

    /**
     * Check if a specific session belongs to the current user
     */
    public function isSessionOwned(string $sessionId, ?int $userId = null, ?string $guard = null): bool
    {
        // Auto-detect if not provided
        if (!$userId || !$guard) {
            $authData = $this->getAuthenticatedUser();
            if (!$authData) {
                return false;
            }
            $userId = $authData['user']->id;
            $guard = $authData['guard'];
        }

        return DB::table(config('session.table', 'sessions'))
            ->where('id', $sessionId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Delete a specific session
     */
    public function deleteSession(string $sessionId): bool
    {
        $authData = $this->getAuthenticatedUser();
        if (!$authData) {
            return false;
        }

        $userId = $authData['user']->id;
        $guard = $authData['guard'];

        // Verify session belongs to user
        if (!$this->isSessionOwned($sessionId, $userId, $guard)) {
            Log::warning('Attempted to delete session not owned by user', [
                'user_id' => $userId,
                'session_id' => $sessionId
            ]);
            return false;
        }

        // Delete from database
        $deleted = DB::table(config('session.table', 'sessions'))
            ->where('id', $sessionId)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            // Also try to clear from Redis cache
            $this->clearSpecificRedisSession($sessionId);
            
            Log::info('Deleted specific session', [
                'user_id' => $userId,
                'guard' => $guard,
                'session_id' => $sessionId
            ]);
        }

        return $deleted > 0;
    }

    /**
     * Clear a specific Redis session
     */
    protected function clearSpecificRedisSession(string $sessionId): void
    {
        try {
            $possibleKeys = [
                'laravel_cache_' . $sessionId,
                'laravel_session_' . $sessionId,
                $sessionId,
            ];

            foreach ($possibleKeys as $key) {
                if (Redis::exists($key)) {
                    Redis::del($key);
                    Log::info('Deleted specific Redis session', ['key' => $key]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error deleting specific Redis session', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }
}