<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Models\Country;
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
            'countries' => Country::orderBy('name', 'asc')->get(),
        ]);
    }

    public function save()
    {
        $this->form->validate();
        // dd($this->form);
        try {
            $dto = CreateUserDTO::fromArray([
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'password' => $this->form->password,
                'phone' => $this->form->phone,
                'status' => $this->form->status,
                'avatar' => $this->form->avatar,
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
