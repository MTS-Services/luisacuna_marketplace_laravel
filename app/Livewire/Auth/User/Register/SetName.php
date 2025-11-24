<?php

namespace App\Livewire\Auth\User\Register;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Traits\Livewire\WithNotification;

class SetName extends Component
{
    use WithNotification;

    #[Validate('required|string|min:2|max:255')]
    public $first_name = '';

    #[Validate('required|string|min:2|max:255')]
    public $last_name = '';

    public function mount()
    {
        // Initialize session with 24 hour expiry if not exists
        if (!session()->has('registration.started_at')) {
            session([
                'registration.started_at' => now(),
                'registration.expires_at' => now()->addHours(24)
            ]);
        }

        // Check if session expired
        if (session('registration.expires_at') && now()->gt(session('registration.expires_at'))) {
            session()->forget('registration');
            $this->error('Registration session expired. Please start again.');
            return;
        }

        // Load existing data if available
        $this->first_name = session('registration.first_name', '');
        $this->last_name = session('registration.last_name', '');
    }

    public function save()
    {
        $this->validate();

        // Store in session with expiry
        session([
            'registration.first_name' => $this->first_name,
            'registration.last_name' => $this->last_name,
            'registration.step' => 'name_completed',
            'registration.expires_at' => now()->addHours(24)
        ]);

        // $this->success('Name saved successfully');
        return $this->redirect(route('register.emailVerify'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.user.register.set-name');
    }
}