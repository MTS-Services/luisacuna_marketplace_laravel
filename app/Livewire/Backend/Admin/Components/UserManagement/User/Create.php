<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use Livewire\Component;
use App\Enums\UserStatus;
use Livewire\WithFileUploads;
use App\DTOs\User\CreateUserDTO;
use App\Services\User\UserService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;

class Create extends Component
{
    use WithFileUploads, WithNotification;


    public UserForm $form;

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function mount(): void
    {
        $this->form->status = UserStatus::ACTIVE->value;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.create', [
            'statuses' => UserStatus::options(),
        ]);
    }

    public function save()
    {
        $this->form->validate();
        try {
            $dto = CreateUserDTO::fromArray([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password,
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
            ]);

            $user = $this->userService->CreateUser($dto);

            $this->dispatch('User Created');
            $this->success('User created successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
