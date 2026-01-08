<?php

namespace App\Traits;

use App\Models\Device;
use App\Services\FirebaseService;
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
     * Register a new device - ALWAYS create new record per session.
     * Each browser profile/tab gets its own session = own device record.
     */
    public function registerDevice(array $deviceData): Device
    {
        $sessionId = session()->getId();

        // Check if device with THIS session already exists
        $existingDevice = $this->devices()
            ->where('session_id', $sessionId)
            ->first();

        if ($existingDevice) {
            // Update existing device for this session
            $existingDevice->update([
                'fcm_token' => $deviceData['fcm_token'] ?? $existingDevice->fcm_token,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'is_active' => true,
                'last_used_at' => now(),
                'logged_out_at' => null,
                'device_name' => $deviceData['device_name'] ?? $existingDevice->device_name,
                'device_model' => $deviceData['device_model'] ?? $existingDevice->device_model,
                'os_version' => $deviceData['os_version'] ?? $existingDevice->os_version,
                'app_version' => $deviceData['app_version'] ?? $existingDevice->app_version,
                'device_fingerprint' => $deviceData['device_fingerprint'] ?? $existingDevice->device_fingerprint,
            ]);

            Log::info('Device updated for session', [
                'device_id' => $existingDevice->id,
                'session_id' => $sessionId,
            ]);

            return $existingDevice;
        }

        // Create new device for this session
        $device = $this->devices()->create([
            'fcm_token' => $deviceData['fcm_token'] ?? null,
            'device_type' => $deviceData['device_type'] ?? 'web',
            'device_name' => $deviceData['device_name'] ?? null,
            'device_model' => $deviceData['device_model'] ?? null,
            'os_version' => $deviceData['os_version'] ?? null,
            'app_version' => $deviceData['app_version'] ?? null,
            'session_id' => $sessionId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_fingerprint' => $deviceData['device_fingerprint'] ?? $this->generateDeviceFingerprint($deviceData),
            'is_active' => true,
            'last_used_at' => now(),
        ]);

        Log::info('New device created', [
            'device_id' => $device->id,
            'session_id' => $sessionId,
            'fingerprint' => $deviceData['device_fingerprint'] ?? 'none',
        ]);

        return $device;
    }

    /**
     * Generate unique device fingerprint.
     */
    protected function generateDeviceFingerprint(array $deviceData): string
    {
        // If frontend provided fingerprint, use it
        if (!empty($deviceData['device_fingerprint'])) {
            return $deviceData['device_fingerprint'];
        }

        // Generate server-side fingerprint from available data
        $components = [
            $deviceData['device_name'] ?? 'unknown',
            $deviceData['device_model'] ?? 'unknown',
            $deviceData['os_version'] ?? 'unknown',
            // $deviceData['fcm_token'] ?? 'unknown',
            request()->userAgent(),
            // Don't include IP as it can change
        ];

        return hash('sha256', implode('|', $components));
    }

    /**
     * Get current device.
     */
    public function getCurrentDevice(): ?Device
    {
        return $this->devices()
            ->bySession(session()->getId())
            ->active()
            ->first();
    }

    /**
     * Logout from current device only.
     */
    public function logoutCurrentDevice(): bool
    {
        $device = $this->getCurrentDevice();

        if ($device) {
            session()->invalidate();
            session()->regenerateToken();
            $device->logout();
            // Send Firebase notification
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
        // Increment session version to invalidate all sessions
        $this->increment('session_version');
        $this->update(['all_devices_logged_out_at' => now()]);

        // Get devices to logout
        $query = $this->devices()->active();

        if (!$includingCurrent) {
            $query->where('session_id', '!=', session()->getId());
        }

        $devices = $query->get();
        $count = $devices->count();

        // Logout each device
        foreach ($devices as $device) {
            $device->logout();

            // Send Firebase notification to each device
            $this->sendLogoutNotification($device, true);
        }

        return $count;
    }

    /**
     * Logout from specific device.
     */
    public function logoutDevice(int $deviceId): bool
    {
        $device = $this->devices()->find($deviceId);

        if ($device && $device->is_active) {
            $device->logout();

            // Send Firebase notification
            $this->sendLogoutNotification($device);

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
            $device->logout();
            $this->sendLogoutNotification($device);
            return $device->delete();
        }

        return false;
    }

    /**
     * Send logout notification via Firebase.
     */
    protected function sendLogoutNotification(Device $device, bool $isAllDevices = false): void
    {
        if (!$device->fcm_token) {
            return;
        }

        $title = $isAllDevices
            ? 'Logged Out from All Devices'
            : 'Device Logged Out';

        $body = $isAllDevices
            ? 'You have been logged out from all devices. Please login again if this wasn\'t you.'
            : 'You have been logged out from this device. Please login again if this wasn\'t you.';

        // Send Firebase notification
        try {
            $firebaseService = App::make(FirebaseService::class);
            $firebaseService->sendToDevice(
                $device->fcm_token,
                $title,
                $body,
                [
                    'type' => 'force_logout',
                    'device_id' => $device->id,
                    'timestamp' => now()->toIso8601String(),
                ]
            );
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
                // Inactive devices older than X days
                $query->where('is_active', false)
                    ->where('logged_out_at', '<', now()->subDays($days));
            })
            ->orWhere(function ($query) use ($days) {
                // Active but not used for X days
                $query->where('last_used_at', '<', now()->subDays($days));
            });

        $count = $staleDevices->count();
        $staleDevices->delete();

        return $count;
    }

    /**
     * Get grouped devices by fingerprint for display.
     * Shows similar devices grouped together but maintains separate sessions.
     */
    public function getGroupedDevices()
    {
        return $this->devices()
            ->orderBy('last_used_at', 'desc')
            ->get()
            ->groupBy('device_fingerprint')
            ->map(function ($devices) {
                // If multiple devices share same fingerprint, show them as group
                return [
                    'fingerprint' => $devices->first()->device_fingerprint,
                    'device_name' => $devices->first()->device_name,
                    'device_model' => $devices->first()->device_model,
                    'sessions' => $devices->map(function ($device) {
                        return [
                            'id' => $device->id,
                            'session_id' => $device->session_id,
                            'is_active' => $device->is_active,
                            'is_current' => $device->session_id === session()->getId(),
                            'last_used_at' => $device->last_used_at,
                            'ip_address' => $device->ip_address,
                        ];
                    }),
                ];
            })
            ->values();
    }

    /**
     * Check if session is valid based on session_version.
     */
    public function isSessionValid(): bool
    {
        $device = $this->getCurrentDevice();

        // If no device found, allow it (device will be created during login)
        if (!$device) {
            return true;
        }

        // Check if device was logged out after it was created
        if (
            $this->all_devices_logged_out_at &&
            $device->created_at < $this->all_devices_logged_out_at
        ) {
            return false;
        }

        return $device->is_active;
    }
}
