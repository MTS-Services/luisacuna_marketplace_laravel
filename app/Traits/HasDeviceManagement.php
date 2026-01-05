<?php

namespace App\Traits;

use App\Models\Device;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

trait HasDeviceManagement
{
    /**
     * Get all devices for this user/admin.
     */
    public function devices()
    {
        return $this->morphMany(Device::class, 'source');
    }

    /**
     * Get active devices only.
     */
    public function activeDevices()
    {
        return $this->devices()->active();
    }

    /**
     * Register a new device.
     */
    public function registerDevice(array $deviceData): Device
    {
        // Deactivate any existing device with same FCM token
        $this->devices()
            ->where('fcm_token', $deviceData['fcm_token'])
            ->where('session_id', '!=', session()->getId())
            ->update(['is_active' => false]);

        // Check if device already exists for this session
        $device = $this->devices()
            ->where('session_id', session()->getId())
            ->first();

        if ($device) {
            // Update existing device
            $device->update([
                'fcm_token' => $deviceData['fcm_token'],
                'device_type' => $deviceData['device_type'] ?? 'web',
                'device_name' => $deviceData['device_name'] ?? null,
                'device_model' => $deviceData['device_model'] ?? null,
                'os_version' => $deviceData['os_version'] ?? null,
                'app_version' => $deviceData['app_version'] ?? null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'is_active' => true,
                'last_used_at' => now(),
            ]);

            return $device;
        }

        // Create new device
        return $this->devices()->create([
            'fcm_token' => $deviceData['fcm_token'],
            'device_type' => $deviceData['device_type'] ?? 'web',
            'device_name' => $deviceData['device_name'] ?? null,
            'device_model' => $deviceData['device_model'] ?? null,
            'os_version' => $deviceData['os_version'] ?? null,
            'app_version' => $deviceData['app_version'] ?? null,
            'session_id' => session()->getId(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_fingerprint' => $deviceData['device_fingerprint'] ?? Str::random(32),
            'is_active' => true,
            'last_used_at' => now(),
        ]);
    }

    /**
     * Get current device.
     */
    public function getCurrentDevice(): ?Device
    {
        return $this->devices()
            ->bySession(session()->getId())
            ->first(); // Don't filter by active here
    }

    /**
     * Logout from current device only.
     */
    public function logoutCurrentDevice(): bool
    {
        $device = $this->getCurrentDevice();

        if ($device) {
            $device->logout();
            
            // Delete Redis session immediately
            $this->deleteRedisSession($device->session_id);
            
            $this->sendLogoutNotification($device);
            return true;
        }

        return false;
    }

    /**
     * Logout from all devices.
     */
    public function logoutAllDevices(bool $includingCurrent = false): int
    {
        DB::beginTransaction();
        
        try {
            // Update logout timestamp
            $this->update(['all_devices_logged_out_at' => now()]);

            // Get devices to logout
            $query = $this->devices()->active();

            if (!$includingCurrent) {
                $currentSessionId = session()->getId();
                $query->where('session_id', '!=', $currentSessionId);
            }

            $devices = $query->get();
            $count = $devices->count();

            // Logout each device and destroy their Redis sessions
            foreach ($devices as $device) {
                $device->logout();
                
                // Delete Redis session immediately
                $this->deleteRedisSession($device->session_id);
                
                // Send Firebase notification
                $this->sendLogoutNotification($device, true);
            }

            DB::commit();
            
            Log::info('Logged out from all devices', [
                'user_id' => $this->id,
                'count' => $count,
                'including_current' => $includingCurrent,
            ]);

            return $count;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to logout all devices', [
                'user_id' => $this->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Logout from specific device.
     */
    public function logoutDevice(int $deviceId): bool
    {
        $device = $this->devices()->find($deviceId);

        if ($device && $device->is_active) {
            $device->logout();
            
            // Delete Redis session immediately
            $this->deleteRedisSession($device->session_id);
            
            // Send Firebase notification
            $this->sendLogoutNotification($device);
            
            Log::info('Device logged out', [
                'user_id' => $this->id,
                'device_id' => $deviceId,
                'session_id' => $device->session_id,
            ]);
            
            return true;
        }

        return false;
    }

    /**
     * Remove/delete a device.
     */
    public function removeDevice(int $deviceId): bool
    {
        $device = $this->devices()->find($deviceId);

        if ($device) {
            if ($device->is_active) {
                $device->logout();
                
                // Delete Redis session
                $this->deleteRedisSession($device->session_id);
                
                $this->sendLogoutNotification($device);
            }
            
            return $device->delete();
        }

        return false;
    }

    /**
     * Delete session from Redis.
     * This is the KEY function that actually logs out the browser!
     */
    protected function deleteRedisSession(string $sessionId): void
    {
        try {
            // Laravel stores sessions in Redis with this prefix
            $sessionPrefix = config('database.redis.options.prefix', 'laravel_database_');
            $sessionKey = $sessionPrefix . session()->getName() . ':' . $sessionId;
            
            // Delete from Redis
            Redis::del($sessionKey);
            
            Log::info('Redis session deleted', [
                'session_id' => $sessionId,
                'redis_key' => $sessionKey,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to delete Redis session', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send logout notification via Firebase.
     */
    protected function sendLogoutNotification(Device $device, bool $isAllDevices = false): void
    {
        if (!$device->fcm_token || str_starts_with($device->fcm_token, 'web_')) {
            return;
        }

        $title = $isAllDevices
            ? 'Logged Out from All Devices'
            : 'Device Logged Out';

        $body = $isAllDevices
            ? 'You have been logged out from all devices. Please login again if this wasn\'t you.'
            : 'You have been logged out from this device. Please login again if this wasn\'t you.';

        try {
            $firebaseService = App::make(FirebaseNotificationService::class);
            $firebaseService->sendToDevice(
                $device->fcm_token,
                $title,
                $body,
                [
                    'type' => 'force_logout',
                    'device_id' => $device->id,
                    'session_id' => $device->session_id,
                    'timestamp' => now()->toIso8601String(),
                ]
            );
            
            Log::info('Logout notification sent', [
                'device_id' => $device->id,
                'fcm_token' => substr($device->fcm_token, 0, 10) . '...',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send logout notification', [
                'device_id' => $device->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Clean up stale devices (inactive for X days).
     */
    public function cleanupStaleDevices(int $days = 30): int
    {
        $staleDevices = $this->devices()
            ->where(function ($query) use ($days) {
                $query->where('last_used_at', '<', now()->subDays($days))
                    ->orWhere(function ($q) use ($days) {
                        $q->where('is_active', false)
                            ->where('logged_out_at', '<', now()->subDays($days));
                    });
            });

        $count = $staleDevices->count();
        
        // Delete their Redis sessions too
        foreach ($staleDevices->get() as $device) {
            $this->deleteRedisSession($device->session_id);
        }
        
        $staleDevices->delete();

        return $count;
    }

    /**
     * Check if session is valid (called by middleware).
     */
    public function isSessionValid(): bool
    {
        $device = $this->getCurrentDevice();

        // If no device found, session is invalid
        if (!$device) {
            Log::warning('No device found for session', [
                'user_id' => $this->id,
                'session_id' => session()->getId(),
            ]);
            return false;
        }

        // Check if device is inactive
        if (!$device->is_active) {
            Log::warning('Device is inactive', [
                'user_id' => $this->id,
                'device_id' => $device->id,
            ]);
            return false;
        }

        // Check if all devices were logged out after this device was created
        if ($this->all_devices_logged_out_at && 
            $device->created_at < $this->all_devices_logged_out_at) {
            Log::warning('Device created before logout all', [
                'user_id' => $this->id,
                'device_created' => $device->created_at,
                'logged_out_all_at' => $this->all_devices_logged_out_at,
            ]);
            return false;
        }

        return true;
    }
}