<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use App\Enums\OtpType;
use Livewire\Component;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

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
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('user.purchased-orders', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        // if ($user && is_null($user->password)) {

        //     session(['registration.user_id' => $user->id]);
        //     session(['registration.email' => $user->email]);

        //     throw ValidationException::withMessages([
        //         $this->redirect(route('register.otp'), navigate: true),
        //     ]);
        // }



        if ($user && is_null($user->password)) {


            session([
                'registration.user_id' => $user->id,
                'registration.email' => $user->email,
            ]);

            $otp = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);

            try {

                Mail::to($user->email)->send(
                    new OtpVerificationMail(
                        $otp->code,
                        $user->first_name,
                        $otp->expires_at
                    )
                );

                Log::info('OTP Email Verification sent for existing user', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp_code' => $otp->code,
                    'expires_at' => $otp->expires_at,
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send OTP email: ' . $mailException->getMessage());
            }

            throw ValidationException::withMessages([
                $this->redirect(route('register.otp'), navigate: true),
            ]);
        }



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

    public function mount()
    {

        if (Auth::guard('web')->check()) {
            return $this->redirectIntended(default: route('user.purchased-orders', absolute: false), navigate: true);
        }
    }
}
