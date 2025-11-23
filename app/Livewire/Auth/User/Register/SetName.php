<?php

namespace App\Livewire\Auth\User\Register;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\User\UserForm;
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

        $this->first_name = session('registration.first_name', '');
        $this->last_name = session('registration.last_name', '');
    }


    public function save()
    {
        $validate = $this->validate();


        session([
            'registration.first_name' => $this->first_name,
            'registration.last_name' => $this->last_name,
        ]);

        $this->success('Name saved successfully');


        return $this->redirect(route('register.emailVerify'), navigate: true);
    }


    public function render()
    {
        return view('livewire.auth.user.register.set-name');
    }
}
