<?php

namespace App\Livewire\Backend\User\Settings;

use Livewire\Component;

class TwoFactorAuthenticaiton extends Component
{
    public $showModal = false;
    public function render()
    {
        return view('livewire.backend.user.settings.two-factor-authenticaiton');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
