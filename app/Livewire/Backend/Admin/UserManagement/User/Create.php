<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\UserAccountStatus;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;
use Illuminate\Support\Facades\Log;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;
    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }
    public function render()
    {

        return view('livewire.backend.admin.user-management.user.create', [
            'statuses' => UserAccountStatus::options(),
        ]);
    }
    public function save()
    {
        $data = $this->form->validate();
        try {
            $user = $this->service->createData($data);

            $this->dispatch('user-created');
            $this->success('User created successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());
            $this->error('Failed to create user.');
        }
    }
    public function resetForm(): void
    {

        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
