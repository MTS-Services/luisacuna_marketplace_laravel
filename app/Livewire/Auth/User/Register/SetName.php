<?php

namespace App\Livewire\Auth\User\Register;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\Livewire\WithNotification;

class SetName extends Component
{
    use WithNotification;

    #[Validate('required|string|min:2|max:255')]
    public $first_name = '';

    #[Validate('required|string|min:2|max:255')]
    public $last_name = '';
    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/^\S*$/')]
    public $password = '';

    #[Validate('required|same:password')]
    public $confirm_password = '';


    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        // // Initialize session with 24 hour expiry if not exists
        // if (!session()->has('registration.started_at')) {
        //     session([
        //         'registration.started_at' => now(),
        //         'registration.expires_at' => now()->addHours(24)
        //     ]);
        // }

        // // Check if session expired
        // if (session('registration.expires_at') && now()->gt(session('registration.expires_at'))) {
        //     session()->forget('registration');
        //     $this->error('Registration session expired. Please start again.');
        //     return;
        // }

        // // Load existing data if available
        // $this->first_name = session('registration.first_name', '');
        // $this->last_name = session('registration.last_name', '');

        // Initialize session
        if (!session()->has('registration.started_at')) {
            session([
                'registration.started_at' => now(),
                'registration.expires_at' => now()->addHours(24)
            ]);
        }

        // Check session expiry
        if (session('registration.expires_at') && now()->gt(session('registration.expires_at'))) {
            session()->forget('registration');
            $this->error('Registration session expired. Please start again.');
        }
    }

    // public function save()
    // {
    //     $this->validate();

    //     // Store in session with expiry
    //     session([
    //         'registration.first_name' => $this->first_name,
    //         'registration.last_name' => $this->last_name,
    //         'registration.step' => 'name_completed',
    //         'registration.expires_at' => now()->addHours(24)
    //     ]);

    //     // $this->success('Name saved successfully');
    //     return $this->redirect(route('register.emailVerify'), navigate: true);
    // }
    private function generateUsername($firstName, $lastName)
    {
        $baseUsername = Str::slug($firstName . '-' . $lastName);
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . $counter;
            $counter++;
        }

        return $username;
    }

    public function save()
    {
        $this->validate();

        try {
            // Generate OTP
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = now()->addMinutes(10);

            $user = $this->service->createData([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'username' => $this->generateUsername($this->first_name, $this->last_name),
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'email_verified_at' => null,
                'avatar' => null,
            ]);

            // Send OTP email
            Mail::to($this->email)->send(
                new OtpVerificationMail(
                    $otpCode,
                    $this->first_name,
                    $expiresAt
                )
            );

            // Store OTP and user info in session
            session([
                'registration.user_id' => $user->id,
                'registration.email' => $this->email,
                'registration.otp_code' => $otpCode,
                'registration.otp_expires_at' => $expiresAt,
                'registration.step' => 'otp_pending',
                'registration.expires_at' => now()->addHours(24)
            ]);

            Log::info('User Created - OTP Sent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
            ]);

            $this->success('Account created! Please verify your email.');
            return $this->redirect(route('register.emailVerify'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage(), [
                'email' => $this->email,
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Failed to complete registration. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.user.register.set-name');
    }
}
