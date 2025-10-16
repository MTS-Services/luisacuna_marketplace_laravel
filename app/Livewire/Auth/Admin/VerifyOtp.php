<?php

namespace App\Livewire\Auth\Admin;

use App\Models\Admin;
use App\Notifications\AdminOtpNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.frontend.app')]
#[Title('Verify OTP')]
class VerifyOtp extends Component
{
    #[Validate('required|string|size:6')]
    public string $code = '';

    public ?Admin $admin = null;

    public function mount()
    {
        $adminId = session('admin_otp_id');

        if (!$adminId) {
            return $this->redirect(route('admin.login'), navigate: true);
        }

        $this->admin = Admin::find($adminId);

        if (!$this->admin || !is_null($this->admin->email_verified_at)) {
            return $this->redirect(route('admin.login'), navigate: true);
        }

        // Check if OTP expired
        if ($this->admin->otp_expires_at && now()->isAfter($this->admin->otp_expires_at)) {
            $this->admin->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('admin_otp_id');
            session()->flash('error', 'OTP has expired. Please login again.');

            return $this->redirect(route('admin.login'), navigate: true);
        }
    }

    public function verify()
    {
        $this->validate();

        $throttleKey = 'verify-otp:' . $this->admin->id;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            $this->addError('code', 'Too many attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.');

            return;
        }

        // Verify OTP
        if (!$this->admin->otp || !Hash::check($this->code, $this->admin->otp)) {
            RateLimiter::hit($throttleKey);

            $this->addError('code', 'Invalid OTP code. Please try again.');
            
            $this->dispatch('clear-2fa-auth-code');

            return;
        }

        // Check if OTP expired
        if ($this->admin->otp_expires_at && now()->isAfter($this->admin->otp_expires_at)) {
            $this->addError('code', 'OTP has expired. Please request a new one.');
            
            $this->dispatch('clear-2fa-auth-code');

            return;
        }

        RateLimiter::clear($throttleKey);

        // Mark email as verified and clear OTP
        $this->admin->update([
            'email_verified_at' => now(),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Login the admin
        Auth::guard('admin')->login($this->admin);

        session()->regenerate();
        session()->forget('admin_otp_id');

        session()->flash('success', 'Email verified successfully!');

        return $this->redirect(route('admin.dashboard'), navigate: true);
    }

    public function resendOtp()
    {
        $throttleKey = 'resend-otp:' . $this->admin->id;

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            session()->flash('error', 'Please wait ' . ceil($seconds / 60) . ' minutes before requesting another OTP.');

            return;
        }

        RateLimiter::hit($throttleKey, 300); // 5 minutes

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->admin->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via email
        $this->admin->notify(new AdminOtpNotification($otp));

        session()->flash('success', 'A new OTP has been sent to your email.');
        
        $this->dispatch('clear-2fa-auth-code');
    }

    public function render()
    {
        return view('livewire.auth.admin.verify-otp');
    }
}