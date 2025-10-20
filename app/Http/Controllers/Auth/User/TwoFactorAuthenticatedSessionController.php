<?php

namespace App\Http\Controllers\Auth\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Events\RecoveryCodeReplaced;

class TwoFactorAuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $guard = Auth::guard('web');
        
        // Check if there's a challenged user in session
        if (!$request->session()->has('login.id')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Your session has expired. Please login again.',
            ]);
        }

        // Get the user model
        $model = config('auth.providers.users.model');
        $user = $model::find($request->session()->get('login.id'));

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to find user. Please login again.',
            ]);
        }

        if (!$user->two_factor_secret) {
            return redirect()->route('login')->withErrors([
                'email' => 'Two-factor authentication is not enabled.',
            ]);
        }

        // Check if recovery code is provided
        if ($request->filled('recovery_code')) {
            $recoveryCode = str_replace([' ', '-'], '', $request->input('recovery_code'));
            
            if (!$user->two_factor_recovery_codes) {
                return back()->withErrors([
                    'recovery_code' => 'No recovery codes available.',
                ]);
            }

            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            
            if (!in_array($recoveryCode, $recoveryCodes)) {
                return back()->withErrors([
                    'recovery_code' => 'The provided recovery code was invalid.',
                ]);
            }

            // Replace used recovery code
            $user->replaceRecoveryCode($recoveryCode);
            event(new RecoveryCodeReplaced($user, $recoveryCode));
        } 
        // Check if 2FA code is provided
        elseif ($request->filled('code')) {
            $request->validate([
                'code' => 'required|string|size:6',
            ]);

            $code = $request->input('code');

            // Verify the code using Google2FA
            $google2fa = app(\PragmaRX\Google2FA\Google2FA::class);
            
            $valid = $google2fa->verifyKey(
                decrypt($user->two_factor_secret),
                $code
            );

            if (!$valid) {
                return back()->withErrors([
                    'code' => 'The provided two factor authentication code was invalid.',
                ]);
            }
        } else {
            return back()->withErrors([
                'code' => 'Please provide an authentication code or recovery code.',
            ]);
        }

        // Login the user
        $guard->login($user, $request->session()->get('login.remember', false));

        $request->session()->regenerate();
        
        // Clear the login session data
        $request->session()->forget(['login.id', 'login.remember']);

        return redirect()->intended(route('user.profile'));
    }
}