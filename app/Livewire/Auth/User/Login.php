<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = true;

    // Device registration fields
    public string $fcmToken = '';
    public string $deviceType = 'web';
    public string $deviceName = '';
    public string $deviceModel = '';
    public string $osVersion = '';
    public string $appVersion = '';
    public string $deviceFingerprint = ''; // Add fingerprint field

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
                'login.device_info' => [
                    'fcm_token' => $this->fcmToken,
                    'device_type' => $this->deviceType,
                    'device_name' => $this->deviceName ?: $this->detectBrowser(),
                    'device_model' => $this->deviceModel ?: $this->detectOS(),
                    'os_version' => $this->osVersion,
                    'app_version' => $this->appVersion,
                    'device_fingerprint' => $this->deviceFingerprint, // Store fingerprint
                ],
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        // Clear rate limiter first
        RateLimiter::clear($this->throttleKey());

        // Perform login
        Auth::login($user, $this->remember);

        // Set flag to skip device validation for this request
        Session::put('device_registration_pending', true);

        // Regenerate session AFTER login
        Session::regenerate();

        // Update last login info
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
            'login_attempts' => 0,
        ]);

        // Register device after session is regenerated
        $this->registerUserDevice($user);

        // Clear the flag after device registration
        Session::forget('device_registration_pending');

        // Log successful authentication
        Log::info('Login successful', [
            'user_id' => $user->id,
            'session_id' => session()->getId(),
        ]);

        // Use redirect without wire:navigate to avoid session issues
        $this->redirect(route('profile', $user->username, absolute: false), navigate: false);
    }

    /**
     * Register user's device after successful login.
     */
    protected function registerUserDevice(User $user): void
    {
        try {
            $deviceData = [
                'fcm_token' => $this->fcmToken ?: 'web_' . session()->getId(),
                'device_type' => $this->deviceType,
                'device_name' => $this->deviceName ?: $this->detectBrowser(),
                'device_model' => $this->deviceModel ?: $this->detectOS(),
                'os_version' => $this->osVersion ?: $this->detectOSVersion(),
                'app_version' => $this->appVersion,
                'device_fingerprint' => $this->deviceFingerprint, // Store fingerprint
            ];

            $user->registerDevice($deviceData);
        } catch (\Exception $e) {
            // Log error but don't prevent login
            Log::error('Failed to register device on login', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Set FCM token from frontend (called via Livewire).
     */
    public function setFcmToken(string $token): void
    {
        $this->fcmToken = $token;
    }

    /**
     * Set device information from frontend.
     */
    public function setDeviceInfo(array $deviceInfo): void
    {
        $this->fcmToken = $deviceInfo['fcm_token'] ?? '';
        $this->deviceType = $deviceInfo['device_type'] ?? 'web';
        $this->deviceName = $deviceInfo['device_name'] ?? '';
        $this->deviceModel = $deviceInfo['device_model'] ?? '';
        $this->osVersion = $deviceInfo['os_version'] ?? '';
        $this->appVersion = $deviceInfo['app_version'] ?? '';
        $this->deviceFingerprint = $deviceInfo['device_fingerprint'] ?? '';

        Log::info('Device info received from frontend', [
            'fingerprint' => $this->deviceFingerprint,
            'has_fcm_token' => !empty($this->fcmToken),
        ]);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    /**
     * Detect browser from user agent.
     */
    protected function detectBrowser(): string
    {
        $userAgent = request()->userAgent();

        if (str_contains($userAgent, 'Firefox')) {
            return 'Firefox';
        } elseif (str_contains($userAgent, 'Edg')) {
            return 'Edge';
        } elseif (str_contains($userAgent, 'Chrome')) {
            return 'Chrome';
        } elseif (str_contains($userAgent, 'Safari')) {
            return 'Safari';
        } elseif (str_contains($userAgent, 'Opera') || str_contains($userAgent, 'OPR')) {
            return 'Opera';
        }

        return 'Unknown Browser';
    }

    /**
     * Detect OS from user agent.
     */
    protected function detectOS(): string
    {
        $userAgent = request()->userAgent();

        if (str_contains($userAgent, 'Windows NT 10.0')) {
            return 'Windows 10/11';
        } elseif (str_contains($userAgent, 'Windows')) {
            return 'Windows';
        } elseif (str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS')) {
            return 'macOS';
        } elseif (str_contains($userAgent, 'Linux')) {
            return 'Linux';
        } elseif (str_contains($userAgent, 'Android')) {
            return 'Android';
        } elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) {
            return 'iOS';
        }

        return 'Unknown OS';
    }

    /**
     * Detect OS version from user agent.
     */
    protected function detectOSVersion(): string
    {
        $userAgent = request()->userAgent();

        // Windows version
        if (preg_match('/Windows NT ([\d.]+)/', $userAgent, $matches)) {
            $versions = [
                '10.0' => '10/11',
                '6.3' => '8.1',
                '6.2' => '8',
                '6.1' => '7',
            ];
            return $versions[$matches[1]] ?? $matches[1];
        }

        // macOS version
        if (preg_match('/Mac OS X ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        // Android version
        if (preg_match('/Android ([\d.]+)/', $userAgent, $matches)) {
            return $matches[1];
        }

        // iOS version
        if (preg_match('/OS ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        return '';
    }

    public function mount()
    {
        if (Auth::guard('web')->check()) {
            return $this->redirectIntended(default: route('profile', Auth::user()->username, absolute: false), navigate: true);
        }

        // Auto-detect device info on mount
        $this->deviceName = $this->detectBrowser();
        $this->deviceModel = $this->detectOS();
        $this->osVersion = $this->detectOSVersion();
    }
}
