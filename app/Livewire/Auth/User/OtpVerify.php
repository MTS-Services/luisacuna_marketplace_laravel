<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use App\Enums\OtpType;
use Livewire\Component;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;

class OtpVerify extends Component
{
    // use WithNotification;

    // #[Validate('required|string|size:6')]
    // public $otp_code = '';

    // public $email = '';
    // public $canResend = true;
    // public $remainingTime = 0;
    // public $isVerified = false;

    // public function mount()
    // {
    //     // Check session expiry
    //     if (!session()->has('registration.started_at') || 
    //         now()->gt(session('registration.expires_at'))) {
    //         session()->forget('registration');
    //         $this->error('Registration session expired. Please start again.');
    //         return $this->redirect(route('register.signUp'), navigate: true);
    //     }

    //     // Check if previous steps completed
    //     if (!session()->has('registration.email')) {
    //         $this->error('Please complete the previous steps.');
    //         return $this->redirect(route('register.emailVerify'), navigate: true);
    //     }

    //     // Check if OTP already verified
    //     if (session()->has('registration.otp_verified') && session('registration.otp_verified') === true) {
    //         $this->isVerified = true;
    //         Log::info('OTP Already Verified', [
    //             'email' => session('registration.email')
    //         ]);
    //     }

    //     $this->email = session('registration.email');

    //     if (!$this->isVerified) {
    //         // Only check for OTP code if not verified yet
    //         if (!session()->has('registration.otp_code')) {
    //             $this->error('Please request OTP first.');
    //             return $this->redirect(route('register.emailVerify'), navigate: true);
    //         }
    //         $this->checkRateLimit();
    //     }

    //     Log::info('OTP Verify Mount Success', [
    //         'email' => $this->email,
    //         'is_verified' => $this->isVerified
    //     ]);
    // }

    // private function checkRateLimit()
    // {
    //     $rateLimitKey = 'otp-resend:' . session('registration.email');

    //     if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
    //         $this->remainingTime = RateLimiter::availableIn($rateLimitKey);
    //         $this->canResend = false;

    //         Log::info('Rate limit active', [
    //             'email' => session('registration.email'),
    //             'remaining_seconds' => $this->remainingTime
    //         ]);
    //     } else {
    //         $this->remainingTime = 0;
    //         $this->canResend = true;
    //     }
    // }

    // public function verifyOtp()
    // {
    //     // If already verified, redirect to next step
    //     if ($this->isVerified || (session()->has('registration.otp_verified') && session('registration.otp_verified') === true)) {
    //         $this->success('Email already verified. Proceeding to next step.');
    //         return $this->redirect(route('register.password'), navigate: true);
    //     }

    //     $this->validate();

    //     // Check if OTP expired
    //     if (now()->gt(session('registration.otp_expires_at'))) {
    //         Log::error('OTP Verify Failed: OTP Expired', [
    //             'email' => $this->email,
    //             'expires_at' => session('registration.otp_expires_at')
    //         ]);

    //         return $this->error(
    //             title: 'OTP Expired',
    //             message: 'Your OTP has expired. Please request a new one.'
    //         );
    //     }

    //     // Verify OTP
    //     if (session('registration.otp_code') != $this->otp_code) {
    //         Log::error('OTP Verify Failed: Invalid OTP', [
    //             'email' => $this->email,
    //             'input_otp' => $this->otp_code,
    //         ]);

    //         return $this->error(
    //             title: 'Invalid OTP',
    //             message: 'The OTP you entered is incorrect.'
    //         );
    //     }

    //     // Mark OTP as verified
    //     session([
    //         'registration.otp_verified' => true,
    //         'registration.otp_verified_at' => now(),
    //         'registration.step' => 'otp_completed',
    //         'registration.expires_at' => now()->addHours(24)
    //     ]);

    //     // Clear OTP data from session (security)
    //     session()->forget(['registration.otp_code', 'registration.otp_expires_at']);

    //     // Clear rate limiter after successful verification
    //     $rateLimitKey = 'otp-resend:' . $this->email;
    //     RateLimiter::clear($rateLimitKey);

    //     $this->isVerified = true;

    //     Log::info('OTP Verify Success', [
    //         'email' => $this->email,
    //     ]);

    //     $this->success('Email verified successfully');
    //     return $this->redirect(route('register.password'), navigate: true);
    // }

    // public function resendOtp()
    // {
    //     // If already verified, show message and redirect
    //     if ($this->isVerified || (session()->has('registration.otp_verified') && session('registration.otp_verified') === true)) {
    //         $this->success('Email already verified. Proceeding to next step.');
    //         return $this->redirect(route('register.password'), navigate: true);
    //     }

    //     try {
    //         // Rate limiting check 
    //         $rateLimitKey = 'otp-resend:' . session('registration.email');

    //         if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
    //             $seconds = RateLimiter::availableIn($rateLimitKey);
    //             $this->remainingTime = $seconds;
    //             $this->canResend = false;

    //             return $this->error("Too many attempts. Please wait {$seconds} seconds.");
    //         }

    //         // Generate new OTP
    //         $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $expiresAt = now()->addMinutes(10);

    //         // Send email
    //         Mail::to($this->email)->send(
    //             new OtpVerificationMail(
    //                 $otpCode,
    //                 session('registration.first_name'),
    //                 $expiresAt
    //             )
    //         );

    //         // Update session
    //         session([
    //             'registration.otp_code' => $otpCode,
    //             'registration.otp_expires_at' => $expiresAt,
    //         ]);

    //         // Hit rate limiter (5 minutes = 300 seconds)
    //         RateLimiter::hit($rateLimitKey, 300);

    //         // Update countdown state
    //         $this->remainingTime = 300;
    //         $this->canResend = false;

    //         Log::info('OTP Resent Successfully', [
    //             'email' => $this->email,
    //             'expires_at' => $expiresAt
    //         ]);

    //         return $this->success('New OTP sent successfully. Check your email.');

    //     } catch (\Exception $e) {
    //         Log::error('Failed to resend OTP', [
    //             'email' => session('registration.email'),
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return $this->error('Failed to resend OTP. Please try again.');
    //     }
    // }

    // public function proceedToNextStep()
    // {
    //     if ($this->isVerified || (session()->has('registration.otp_verified') && session('registration.otp_verified') === true)) {
    //         return $this->redirect(route('register.password'), navigate: true);
    //     }

    //     $this->error('Please verify your email first.');
    // }

    // public function back()
    // {
    //     return $this->redirect(route('register.emailVerify'), navigate: true);
    // }
    use WithNotification;

    #[Validate('required|string|size:6')]
    public $otp_code = '';

    public $email = '';
    public $canResend = true;
    public $remainingTime = 0;
    public $isVerified = false;

    public function mount()
    {
        // Check session expiry
        if (
            !session()->has('registration.started_at') ||
            now()->gt(session('registration.expires_at'))
        ) {
            session()->forget('registration');
            $this->error('Registration session expired. Please start again.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // Check if user created
        if (!session()->has('registration.user_id')) {
            $this->error('Please complete registration first.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // Check if already verified
        $user = User::find(session('registration.user_id'));
        if ($user && $user->email_verified_at) {
            $this->isVerified = true;
            Log::info('Email Already Verified', ['email' => $user->email]);
        }

        $this->email = session('registration.email');

        if (!$this->isVerified) {
            if (!session()->has('registration.otp_code')) {
                $this->error('Please request OTP first.');
                return $this->redirect(route('register.signUp'), navigate: true);
            }
            $this->checkRateLimit();
        }
    }

    private function checkRateLimit()
    {
        $rateLimitKey = 'otp-resend:' . session('registration.email');

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->remainingTime = RateLimiter::availableIn($rateLimitKey);
            $this->canResend = false;
        } else {
            $this->remainingTime = 0;
            $this->canResend = true;
        }
    }

    public function verifyOtp()
    {
        // Check if already verified
        $user = User::find(session('registration.user_id'));
        if ($user && $user->email_verified_at) {
            $this->success('Email already verified.');
            return $this->redirect(route('login'), navigate: true);
        }

        $this->validate();

        // Check OTP expiry
        if (now()->gt(session('registration.otp_expires_at'))) {
            Log::error('OTP Expired', ['email' => $this->email]);
            return $this->error(
                title: 'OTP Expired',
                message: 'Your OTP has expired. Please request a new one.'
            );
        }

        // Verify OTP
        if (session('registration.otp_code') != $this->otp_code) {
            Log::error('Invalid OTP', ['email' => $this->email]);
            return $this->error(
                title: 'Invalid OTP',
                message: 'The OTP you entered is incorrect.'
            );
        }

        // Update user's email_verified_at
        $user->update([
            'email_verified_at' => now()
        ]);

        // Clear session
        session()->forget('registration');

        // Clear rate limiter
        $rateLimitKey = 'otp-resend:' . $this->email;
        RateLimiter::clear($rateLimitKey);

        $this->isVerified = true;

        Log::info('Email Verified Successfully', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        $this->success('Email verified successfully! You can now login.');
        return $this->redirect(route('login'), navigate: true);
    }

    public function resendOtp()
    {
        // Check if already verified
        $user = User::find(session('registration.user_id'));
        if ($user && $user->email_verified_at) {
            $this->success('Email already verified.');
            return $this->redirect(route('login'), navigate: true);
        }

        try {
            $rateLimitKey = 'otp-resend:' . session('registration.email');

            if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
                $seconds = RateLimiter::availableIn($rateLimitKey);
                $this->remainingTime = $seconds;
                $this->canResend = false;
                return $this->error("Too many attempts. Please wait {$seconds} seconds.");
            }

            // Generate new OTP
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = now()->addMinutes(10);

            // Send email
            Mail::to($this->email)->send(
                new OtpVerificationMail(
                    $otpCode,
                    $user->first_name,
                    $expiresAt
                )
            );

            // Update session
            session([
                'registration.otp_code' => $otpCode,
                'registration.otp_expires_at' => $expiresAt,
            ]);

            // Hit rate limiter
            RateLimiter::hit($rateLimitKey, 300);

            $this->remainingTime = 300;
            $this->canResend = false;

            Log::info('OTP Resent', ['email' => $this->email]);

            return $this->success('New OTP sent successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP', [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);

            return $this->error('Failed to resend OTP. Please try again.');
        }
    }

    public function back()
    {
        return $this->redirect(route('register.signUp'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.user.otp-verify');
    }
}
