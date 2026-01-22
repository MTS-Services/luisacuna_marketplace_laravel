<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $guard = Auth::guard('admin');

        // Check if there's a challenged user in session
        if (! $request->session()->has('login.id')) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your session has expired. Please login again.',
            ]);
        }

        // Get the admin model
        $model = config('auth.providers.admins.model');
        $admin = $model::find($request->session()->get('login.id'));

        if (! $admin) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Unable to find user. Please login again.',
            ]);
        }

        if (! $admin->two_factor_secret) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Two-factor authentication is not enabled.',
            ]);
        }

        // Validate that at least one field is provided
        $request->validate([
            'code' => 'nullable|string|size:6|required_without:recovery_code',
            'recovery_code' => 'nullable|string|required_without:code',
        ], [
            'code.required_without' => 'Please provide an authentication code or recovery code.',
            'recovery_code.required_without' => 'Please provide an authentication code or recovery code.',
        ]);

        // Check if recovery code is provided
        if ($request->filled('recovery_code')) {
            $result = $this->verifyRecoveryCode($admin, $request->input('recovery_code'));

            if (! $result['valid']) {
                return back()->withErrors([
                    'recovery_code' => $result['message'],
                ]);
            }
        }
        // Check if 2FA code is provided
        elseif ($request->filled('code')) {
            $result = $this->verifyTwoFactorCode($admin, $request->input('code'));

            if (! $result['valid']) {
                return back()->withErrors([
                    'code' => $result['message'],
                ]);
            }
        }

        // Login the admin and keep device validation pending
        $guard->login($admin, $request->session()->get('login.remember', false));

        $request->session()->put('device_registration_pending', true);
        $request->session()->regenerate();

        $this->registerAdminDevice($request, $admin);

        // Clear the login session data
        $request->session()->forget(['login.id', 'login.remember', 'login.device_info']);
        $request->session()->forget('device_registration_pending');

        return redirect()->intended(route('admin.dashboard'));
    }

    protected function registerAdminDevice(Request $request, $admin): void
    {
        $deviceInfo = $request->session()->get('login.device_info', []);

        $deviceData = [
            'fcm_token' => $deviceInfo['fcm_token'] ?? ('web_'.$request->session()->getId()),
            'device_type' => $deviceInfo['device_type'] ?? 'web',
            'device_name' => $deviceInfo['device_name'] ?? $this->detectBrowser($request),
            'device_model' => $deviceInfo['device_model'] ?? $this->detectOS($request),
            'os_version' => $deviceInfo['os_version'] ?? $this->detectOSVersion($request),
            'app_version' => $deviceInfo['app_version'] ?? '',
        ];

        try {
            $admin->registerDevice($deviceData);

            Log::info('Admin device registered after two-factor challenge', [
                'admin_id' => $admin->id,
                'session_id' => $request->session()->getId(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to register admin device after two-factor challenge', [
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function detectBrowser(Request $request): string
    {
        $userAgent = $request->userAgent();

        return match (true) {
            str_contains($userAgent, 'Firefox') => 'Firefox',
            str_contains($userAgent, 'Edg') => 'Edge',
            str_contains($userAgent, 'Chrome') => 'Chrome',
            str_contains($userAgent, 'Safari') => 'Safari',
            str_contains($userAgent, 'Opera') || str_contains($userAgent, 'OPR') => 'Opera',
            default => 'Unknown Browser',
        };
    }

    private function detectOS(Request $request): string
    {
        $userAgent = $request->userAgent();

        return match (true) {
            str_contains($userAgent, 'Windows NT 10.0') => 'Windows 10/11',
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS') => 'macOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            str_contains($userAgent, 'Android') => 'Android',
            str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad') => 'iOS',
            default => 'Unknown OS',
        };
    }

    private function detectOSVersion(Request $request): string
    {
        $userAgent = $request->userAgent();

        if (preg_match('/Windows NT ([\d.]+)/', $userAgent, $matches)) {
            return match ($matches[1]) {
                '10.0' => '10/11',
                '6.3' => '8.1',
                '6.2' => '8',
                '6.1' => '7',
                default => $matches[1],
            };
        }

        if (preg_match('/Mac OS X ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        if (preg_match('/Android ([\d.]+)/', $userAgent, $matches)) {
            return $matches[1];
        }

        if (preg_match('/OS ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        return '';
    }

    /**
     * Verify the two-factor authentication code
     */
    private function verifyTwoFactorCode($admin, $code)
    {
        try {
            $google2fa = app(Google2FA::class);

            $decryptedSecret = decrypt($admin->two_factor_secret);

            $valid = $google2fa->verifyKey($decryptedSecret, $code);

            if (! $valid) {
                return [
                    'valid' => false,
                    'message' => 'The provided two-factor authentication code was invalid.',
                ];
            }

            return ['valid' => true];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'An error occurred while verifying the code.',
            ];
        }
    }

    /**
     * Verify and use a recovery code
     */
    private function verifyRecoveryCode($admin, $recoveryCode)
    {
        try {
            if (! $admin->two_factor_recovery_codes) {
                return [
                    'valid' => false,
                    'message' => 'No recovery codes available.',
                ];
            }

            // Clean up the recovery code (remove spaces and dashes)
            $recoveryCode = str_replace([' ', '-', '_'], '', $recoveryCode);
            $recoveryCode = strtolower(trim($recoveryCode));

            Log::info('Recovery code verification attempt', [
                'admin_id' => $admin->id,
                'recovery_code_input' => $recoveryCode,
            ]);

            // Decrypt and parse recovery codes
            $decryptedCodes = decrypt($admin->two_factor_recovery_codes);
            $recoveryCodes = json_decode($decryptedCodes, true);

            if (! is_array($recoveryCodes)) {
                Log::error('Recovery codes format invalid', ['admin_id' => $admin->id]);

                return [
                    'valid' => false,
                    'message' => 'Recovery codes format is invalid.',
                ];
            }

            // Normalize all codes to lowercase for comparison
            $normalizedCodes = array_map(function ($code) {
                return strtolower(str_replace([' ', '-', '_'], '', $code));
            }, $recoveryCodes);

            Log::info('Available recovery codes count', [
                'admin_id' => $admin->id,
                'count' => count($normalizedCodes),
            ]);

            // Check if the code exists in the list (case-insensitive)
            $codeKey = array_search($recoveryCode, $normalizedCodes);

            if ($codeKey === false) {
                Log::warning('Recovery code not found', [
                    'admin_id' => $admin->id,
                    'provided' => $recoveryCode,
                    'available' => implode(', ', array_slice($normalizedCodes, 0, 2)).'...',
                ]);

                return [
                    'valid' => false,
                    'message' => 'The provided recovery code was invalid or has already been used.',
                ];
            }

            // Remove the used code from the array
            unset($recoveryCodes[$codeKey]);

            // Update the recovery codes in the database
            $admin->two_factor_recovery_codes = encrypt(json_encode(array_values($recoveryCodes)));
            $admin->save();

            // Fire event for recovery code replacement
            event(new RecoveryCodeReplaced($admin, $recoveryCode));

            return ['valid' => true];
        } catch (\Exception $e) {
            Log::error('Recovery code verification error: '.$e->getMessage());

            return [
                'valid' => false,
                'message' => 'An error occurred while verifying the recovery code.',
            ];
        }
    }
}
