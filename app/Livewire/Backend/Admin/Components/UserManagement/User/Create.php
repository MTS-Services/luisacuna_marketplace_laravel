<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\DTOs\User\CreateUserDTO;
use App\Enums\UserAccountStatus;
use App\Services\User\UserService;
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
    public function mount(): void
    {
        $this->form->account_status = UserAccountStatus::ACTIVE->value;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.create', [
            'statuses' => UserAccountStatus::options(),
            'countries' => Country::orderBy('name', 'asc')->get(),
        ]);
    }

    public function save()
    {
        $this->form->validate();

        try {
            $data = $this->form->fillables();

            $user = $this->service->createData($data);

            $this->dispatch('User Created');
            $this->success('User created successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user:' . $e->getMessage());
            $this->error('Failed to create user.');
            dd($e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
