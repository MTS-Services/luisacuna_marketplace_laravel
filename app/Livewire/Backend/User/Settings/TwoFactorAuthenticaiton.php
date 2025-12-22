<?php

namespace App\Livewire\Backend\User\Settings;

use Livewire\Component;

class TwoFactorAuthenticaiton extends Component
{
    public $showModal = false;
    public $showQrCode = false;
    public $step = 1;

    public function render()
    {
        return view('livewire.backend.user.settings.two-factor-authenticaiton');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function generateQrCode(){
        $this->showQrCode = true;
    }

    public function nextStep(){
        $this->step = $this->step + 1 ;
    }
    public function previousStep(){
        $this->step = $this->step - 1 ;
    }
    public function verifySetup(){
        // Verification logic here
        $this->step = 1;
        $this->showModal = false;
    }
    public function ShowCode(){
        $this->showQrCode = false;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
}
