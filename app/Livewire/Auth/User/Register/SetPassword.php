<?php

namespace App\Livewire\Auth\User\Register;

use App\Models\User;
use App\Services\UserService;
use Livewire\Component;
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
        if (!session()->has('registration.user_id')) {
            session()->flash('error', 'Session expired. Please start registration again.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }

        // $user = User::find(session('registration.user_id'));

        $user = $this->service->getDataById(session('registration.user_id'));
        
        if (!$user || !$user->email_verified_at) {
            session()->flash('error', 'Please verify your email first.');
            return $this->redirect(route('register.otp'), navigate: true);
        }
    }

    public function save()
    {
        // $this->validate();

        try {
            // $user = User::find(session('registration.user_id'));

            $user = $this->service->getDataById(session('registration.user_id'));

            if (!$user) {
                $this->error('User not found. Please start registration again.');
                session()->flash('error', 'User not found. Please start registration again.');
                return $this->redirect(route('register.signUp'), navigate: true);
            }

            $user->update([
                'password' => Hash::make($this->password),
            ]);

            Log::info('User registration completed', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            $this->dispatch('user-registered');
            $this->success('Registration completed successfully!');

            session()->forget('registration');

            return $this->redirect(route('home'), navigate: true);

        } catch (\Exception $e) {
            // Log error with trace
            Log::error('Failed to set password: ' . $e->getMessage(), [
                'user_id' => session('registration.user_id'),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Failed to set password. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.user.register.set-password');
    }
}
