<?php

namespace App\Livewire\Auth\Admin;

use App\Enums\OtpType;
use App\Notifications\AdminOtpNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class VerifyOtp extends Component
{
    #[Validate('required|string|size:6')]
    public string $code = '';

    public function mount()
    {
        // Redirect if not authenticated
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        // Redirect if already verified
        if (is_email_verified(admin())) {
            return redirect()->route('admin.dashboard');
        }

        // Generate and send OTP when component loads
        $this->sendOtp();
    }

    protected function sendOtp(): void
    {
        $admin = admin();

        // Check if there's a valid unexpired OTP
        if (has_valid_otp($admin, OtpType::EMAIL_VERIFICATION)) {
            session()->flash('message', 'A verification code was already sent to your email.');
            return;
        }

        // Create new OTP
        $otpVerification = create_otp($admin, OtpType::EMAIL_VERIFICATION, 10);

        // Send OTP via email
        Log::info('OTP Code for Admin ID ' . $admin->id . ': ' . $otpVerification->code);
        $admin->notify(new AdminOtpNotification($otpVerification->code));

        session()->flash('message', 'Verification code has been sent to your email.');
    }

    public function verify(): void
{
    try {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $admin = admin();
        $otpVerification = $admin->latestOtp(OtpType::EMAIL_VERIFICATION);

        // Check if OTP exists
        if (!$otpVerification) {
            throw ValidationException::withMessages([
                'code' => 'No verification code found. Please request a new one.',
            ]);
        }

        // Check if already verified
        if ($otpVerification->isVerified()) {
            throw ValidationException::withMessages([
                'code' => 'This verification code has already been used.',
            ]);
        }

        // Check if expired
        if ($otpVerification->isExpired()) {
            throw ValidationException::withMessages([
                'code' => 'The verification code has expired. Please request a new one.',
            ]);
        }

        // Check max attempts (5 attempts)
        if ($otpVerification->attempts >= 5) {
            throw ValidationException::withMessages([
                'code' => 'Too many failed attempts. Please request a new code.',
            ]);
        }

        // Verify the code
        if (!verify_otp($admin, $this->code, OtpType::EMAIL_VERIFICATION)) {
            RateLimiter::hit($this->throttleKey());

            $remainingAttempts = 5 - $otpVerification->fresh()->attempts;

            throw ValidationException::withMessages([
                'code' => "The verification code is incorrect. {$remainingAttempts} attempts remaining.",
            ]);
        }

        // Mark email as verified
        $admin->markEmailAsVerified();

        RateLimiter::clear($this->throttleKey());

        session()->flash('message', 'Email verified successfully!');
        $this->redirect(route('admin.dashboard'), navigate: true);

    } catch (ValidationException $e) {
        // Re-throw validation errors to be handled normally by Livewire
        throw $e;

    } catch (\Throwable $e) {
        // Catch all unexpected errors and log them for debugging
        Log::error('OTP verification failed', [
            'admin_id' => $admin->id ?? null,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Show a generic error message
        session()->flash('error', 'Something went wrong while verifying your code. Please try again.');
    }
}

    public function resend(): void
    {
        $this->ensureResendIsNotRateLimited();

        $admin = admin();

        // Create new OTP
        $otpVerification = create_otp($admin, OtpType::EMAIL_VERIFICATION, 10);

        // Send OTP via email
        Log::info('Resent OTP Code for Admin ID ' . $admin->id . ': ' . $otpVerification->code);
        $admin->notify(new AdminOtpNotification($otpVerification->code));

        RateLimiter::hit($this->resendThrottleKey(), 60); // 1 minute cooldown

        session()->flash('message', 'A new verification code has been sent to your email.');

        $this->dispatch('clear-auth-code');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'code' => "Too many verification attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    protected function ensureResendIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->resendThrottleKey(), 1)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->resendThrottleKey());

        throw ValidationException::withMessages([
            'code' => "Please wait {$seconds} seconds before requesting a new code.",
        ]);
    }

    protected function throttleKey(): string
    {
        return 'otp-verify:' . admin()->id . ':' . request()->ip();
    }

    protected function resendThrottleKey(): string
    {
        return 'otp-resend:' . admin()->id . ':' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.admin.verify-otp');
    }
}
