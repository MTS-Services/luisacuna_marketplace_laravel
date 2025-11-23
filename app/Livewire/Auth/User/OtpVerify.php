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

class OtpVerify extends Component
{
    use WithNotification;

    #[Validate('required|string')]
    public $otp_code = '';

    public $email = '';
    public $remaining_time = null;
    public $formatted_time = '';

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


        $this->loadRemainingTime();
    }



    public function loadRemainingTime()
    {
        try {

            $user = $this->service->getDataById(session('registration.user_id'));

            if ($user) {
                $this->remaining_time = get_otp_remaining_time($user, OtpType::EMAIL_VERIFICATION);
                $this->formatted_time = format_otp_time($this->remaining_time);

                Log::info('OTP Remaining Time Loaded', [
                    'remaining_time' => $this->remaining_time,
                    'formatted_time' => $this->formatted_time
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to load OTP time: ' . $e->getMessage());
        }
    }


    public function verifyOtp()
    {
        $user = User::find(session('registration.user_id'));

        if (! $user) {
            Log::error('OTP Verify Failed: User not found', [
                'user_id' => session('registration.user_id'),
            ]);

            return $this->error(
                title: 'User Not Found',
                message: 'No account found.'
            );
        }

        $otp = \App\Models\OtpVerification::where('verifiable_id', $user->id)
            ->where('type', OtpType::EMAIL_VERIFICATION)
            ->latest()
            ->first();

        if (! $otp) {
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
                'actual_otp' => $otp->code
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
            // $user = User::find(session('registration.user_id'));

            $user = $this->service->getDataById(session('registration.user_id'));

            if (!$user) {
                $this->error('User not found.');
                return;
            }

            $otp = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);

            // Send OTP via email
            Mail::to($user->email)->send(
                new OtpVerificationMail(
                    $otp->code,
                    $user->first_name,
                    $otp->expires_at
                )
            );

            Log::info('OTP Resent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'otp_code' => $otp->code,
                'expires_at' => $otp->expires_at
            ]);

            $this->loadRemainingTime();
            $this->success('New OTP sent successfully. Check your email.');
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP: ' . $e->getMessage());
            $this->error('Failed to resend OTP. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.user.otp-verify');
    }
}
