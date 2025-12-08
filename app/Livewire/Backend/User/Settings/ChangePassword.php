<?php

namespace App\Livewire\Backend\User\Settings;

use Livewire\Component;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\PasswordChangeForm;
use Illuminate\Validation\ValidationException;

class ChangePassword extends Component
{

    use WithNotification;

    public bool $showModal = false;
    public PasswordChangeForm $form;
    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->form->reset();
        $this->resetValidation();
    }

    /**
     * Change user password using existing updateData method
     */
    public function changePassword()
    {
        try {
            $data =   $this->form->validate();
            $data = [
                'password_old' => $this->form->password_old,
                'password' => $this->form->password,
                'password_confirmation' => $this->form->password_confirmation,
            ];

            $this->service->updateData(auth()->id(), $data);

            $this->closeModal();
            $this->success(__('Password changed successfully!'));

            $this->dispatch('password-changed');
        } catch (ValidationException $e) {
            $this->error(__('Please check the form for errors.'));
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password change failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error(__('Password change failed. Please try again.'));
        }
    }

    public function render()
    {
        return view('livewire.backend.user.settings.change-password');
    }
}
