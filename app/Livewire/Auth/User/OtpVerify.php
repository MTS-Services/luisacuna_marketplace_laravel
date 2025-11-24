<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use App\Enums\OtpType;
use Livewire\Component;
use App\Services\UserService;
use App\Models\OtpVerification;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;

class OtpVerify extends Component
{
    use WithNotification;

    #[Validate('required|string')]
    public $otp_code = '';

    public $email = '';
    
    public $canResend = true;
    public $remainingTime = 0;

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        if (!session()->has('registration.user_id')) {
            Log::error('OTP Verify Mount: User ID not found in session');
            session()->flash('error', 'Session expired. Please start registration again.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        $this->email = session('registration.email', '');

        Log::info('OTP Verify Mount Success', [
            'user_id' => session('registration.user_id'),
            'email' => $this->email
        ]);

        $this->checkRateLimit();
    }

    /**
     * Rate limit check 
     */
    public function checkRateLimit()
    {
        $userId = session('registration.user_id');
        $rateLimitKey = 'otp-resend:' . $userId;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->remainingTime = RateLimiter::availableIn($rateLimitKey);
            $this->canResend = false;
            
            Log::info('Rate limit active', [
                'user_id' => $userId,
                'remaining_seconds' => $this->remainingTime
            ]);
        } else {
            $this->remainingTime = 0;
            $this->canResend = true;
        }
    }

    public function verifyOtp()
    {
        $user = User::find(session('registration.user_id'));

        if (!$user) {
            Log::error('OTP Verify Failed: User not found', [
                'user_id' => session('registration.user_id'),
            ]);

            return $this->error(
                title: 'User Not Found',
                message: 'No account found.'
            );
        }

        $otp = OtpVerification::where('verifiable_id', $user->id)
            ->where('type', OtpType::EMAIL_VERIFICATION)
            ->latest()
            ->first();

        if (!$otp) {
            Log::error('OTP Verify Failed: OTP record not found', [
                'user_id' => $user->id,
            ]);

            return $this->error(
                title: 'OTP Not Found',
                message: 'OTP record not found.'
            );
        }

        if (now()->greaterThan($otp->expires_at)) {
            Log::error('OTP Verify Failed: OTP Expired', [
                'user_id' => $user->id,
                'expires_at' => $otp->expires_at
            ]);

            return $this->error(
                title: 'OTP Expired',
                message: 'Your OTP has expired. Please request a new one.'
            );
        }

        if ($otp->code != $this->otp_code) {
            Log::error('OTP Verify Failed: Invalid OTP', [
                'email' => $user->email,
                'input_otp' => $this->otp_code,
            ]);

            return $this->error(
                title: 'Invalid OTP',
                message: 'The OTP you entered is incorrect.'
            );
        }

        $user->update([
            'email_verified_at' => now(),
        ]);
        
        $otp->delete();

        Log::info('OTP Verify Success', [
            'email' => $user->email,
            'user_id' => $user->id,
        ]);

        return $this->redirect(route('register.password'), navigate: true);
    }

    public function resendOtp()
    {
        try {
            // Step 1: User validation
            $user = $this->service->getDataById(session('registration.user_id'));

            if (!$user) {
                return $this->error('User not found.');
            }

            // Step 2: Rate limiting check 
            $rateLimitKey = 'otp-resend:' . $user->id;

            if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
                $seconds = RateLimiter::availableIn($rateLimitKey);
                $this->remainingTime = $seconds;
                $this->canResend = false;
                
                return $this->error("Too many attempts. Please wait {$seconds} seconds.");
            }

            // Step 3: OTP creation
            $otp = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);

            // Step 4: Send email
            Mail::to($user->email)->send(
                new OtpVerificationMail(
                    $otp->code,
                    $user->first_name,
                    $otp->expires_at
                )
            );

            // Step 5: Hit rate limiter (5 minutes = 300 seconds)
            RateLimiter::hit($rateLimitKey, 300);

            // Step 6: Update countdown state
            $this->remainingTime = 300;
            $this->canResend = false;

            // Step 7: Logging (without OTP code)
            Log::info('OTP Resent Successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'expires_at' => $otp->expires_at
            ]);

            return $this->success('New OTP sent successfully. Check your email.');
            
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP', [
                'user_id' => session('registration.user_id'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error('Failed to resend OTP. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.user.otp-verify');
    }
}