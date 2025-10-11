<?php

namespace App\Http\Livewire\User;

use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserStatus;
use App\Http\Livewire\User\Forms\UserForm;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Edit User')]
class UserEdit extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;
    public User $user;
    public $existingAvatar;

    public function __construct(
        protected UserService $userService
    ) {
        parent::__construct();
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->form->setUser($user);
        $this->existingAvatar = $user->avatar_url;
    }

    public function render()
    {
        return view('livewire.user.user-edit', [
            'statuses' => UserStatus::options(),
        ]);
    }

    public function save()
    {
        $this->form->validate();

        try {
            $dto = UpdateUserDTO::fromArray([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password,
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
                'avatar' => $this->form->avatar,
                'remove_avatar' => $this->form->remove_avatar,
            ]);

            $this->user = $this->userService->updateUser($this->user->id, $dto);
            
            $this->existingAvatar = $this->user->avatar_url;
            $this->form->avatar = null;
            $this->form->remove_avatar = false;

            $this->dispatch('userUpdated');
            $this->success('User updated successfully'); 

            // Redirect to user list
            return $this->redirect(route('users.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update user: ' . $e->getMessage());
        }
    }

    public function removeAvatar(): void
    {
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

    public function cancel(): void
    {
        $this->redirect(route('users.index'), navigate: true);
    }
}