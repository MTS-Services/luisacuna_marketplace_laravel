<?php

namespace App\Livewire\User;

use App\Actions\User\CreateUserAction;
use App\Livewire\Forms\User\UserForm;
use Livewire\Component;

class UserCreate extends Component
{
    public UserForm $form;
    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;
    public string $phone;
    public string $status;

    public function mount()
    {
        $this->form = new UserForm();
    }

    public function create(CreateUserAction $action)
    {
        $this->validate();

        try {
            $action->execute($this->form->toArray());

            $this->success('User created successfully!');

            $this->dispatch('userCreated');

            $this->form->reset();

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.user-create', [
            'statusOptions' => UserStatus::options(),
        ]);
    }
}
