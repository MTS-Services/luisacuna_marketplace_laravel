<?php

namespace App\Livewire\Auth\User\Register;

use App\Models\User;
use App\Services\UserService;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use App\Traits\Livewire\WithNotification;

class SetPassword extends Component
{
    use WithNotification;

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    #[Validate('required|string')]
    public $password_confirmation = '';

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        // Check session expiry
        if (!session()->has('registration.started_at') || 
            now()->gt(session('registration.expires_at'))) {
            session()->forget('registration');
            $this->error('Registration session expired. Please start again.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // Check if all previous steps completed
        if (!session()->has('registration.otp_verified') || 
            !session('registration.otp_verified')) {
            $this->error('Please verify your email first.');
            return $this->redirect(route('register.otp'), navigate: true);
        }

        // Verify all required data exists
        if (!session()->has('registration.first_name') || 
            !session()->has('registration.last_name') || 
            !session()->has('registration.email')) {
            $this->error('Registration data incomplete. Please start again.');
            session()->forget('registration');
            return $this->redirect(route('register.signUp'), navigate: true);
        }
    }

    private function generateUsername($firstName, $lastName)
    {
        // Create base username
        $baseUsername = Str::slug($firstName . '-' . $lastName);
        $username = $baseUsername;
        $counter = 1;

        // Check if username exists and make it unique
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
            $firstName = session('registration.first_name');
            $lastName = session('registration.last_name');
            $email = session('registration.email');

            // Create user with all collected data
            $user = $this->service->createData([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $this->generateUsername($firstName, $lastName),
                'email' => $email,
                'password' => Hash::make($this->password),
                'email_verified_at' => session('registration.otp_verified_at'),
                'avatar' => null,
            ]);

            Log::info('User registration completed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'created_at' => $user->created_at
            ]);

            // Dispatch success event
            $this->dispatch('user-registered');
            $this->success('Registration completed successfully!');

            // Clear all registration session data
            session()->forget('registration');

            return $this->redirect(route('login'), navigate: true);

        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage(), [
                'email' => session('registration.email'),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Failed to complete registration. Please try again.');
        }
    }

    public function back()
    {
        // Clear password verification status if going back
        session()->forget(['registration.otp_verified', 'registration.otp_verified_at']);
        
        return $this->redirect(route('register.otp'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.user.register.set-password');
    }
}