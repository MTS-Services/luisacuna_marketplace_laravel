<?php

namespace App\Livewire\Auth\User\Register;

use App\Models\User;
use App\Enums\OtpType;
use Livewire\Component;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\Livewire\WithNotification;

class SetEmail extends Component
{
    use WithNotification;

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    public function mount()
    {
        // Check session expiry
        if (!session()->has('registration.started_at') || 
            now()->gt(session('registration.expires_at'))) {
            session()->forget('registration');
            $this->error('Registration session expired. Please start again.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // Check if previous step completed
        if (!session()->has('registration.first_name') || 
            !session()->has('registration.last_name')) {
            $this->error('Please complete the previous step.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // Load existing email if available
        $this->email = session('registration.email', '');
    }

    public function save()
    {
        $this->validate();

        try {
            // Generate OTP
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = now()->addMinutes(10);

            // Send OTP via email
            Mail::to($this->email)->send(
                new OtpVerificationMail(
                    $otpCode,
                    session('registration.first_name'),
                    $expiresAt
                )
            );

            // Store email and OTP in session
            session([
                'registration.email' => $this->email,
                'registration.otp_code' => $otpCode,
                'registration.otp_expires_at' => $expiresAt,
                'registration.step' => 'email_completed',
                'registration.expires_at' => now()->addHours(24)
            ]);

            Log::info('OTP Email Sent', [
                'email' => $this->email,
                'otp_code' => $otpCode,
                'expires_at' => $expiresAt,
            ]);

            $this->success('Verification code sent to your email');
            return $this->redirect(route('register.otp'), navigate: true);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            $this->error('Failed to send verification code. Please try again.');
        }
    }

    public function back()
    {
        return $this->redirect(route('register.signUp'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.user.register.set-email');
    }
}