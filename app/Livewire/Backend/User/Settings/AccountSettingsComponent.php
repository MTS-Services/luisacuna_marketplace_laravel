<?php

namespace App\Livewire\Backend\User\Settings;

use App\Livewire\Forms\User\UserForm;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AccountSettingsComponent extends Component
{
    use WithFileUploads, WithNotification;

    public $userId = null;
    public $firstName = null;
    public $lastName = null;
    public $email = null;
    public $phone = null;
    public $avater = null;
    public $dateOfBirth = null;
    public $description = null;
    public $existingFile;




    public UserForm $form;
    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $user = user();
        $this->form->setData($user);
        $this->existingFile = $user->avatar;
    }

    public function updateProfile()
    {
        try {
            $validated = $this->form->validate();

            $updatedUser = $this->service->updateData(user()->id, $validated);

            $this->mount();

            $this->success('Data updated successfully.');

            $this->dispatch('profile-updated');
             return $this->redirect(route('user.account-settings'), navigate: true);
        } catch (\Exception $e) {
            Log::error('User profile update failed', [
                'user_id' => user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('User profile update failed: ' . $e->getMessage());
        }
    }


    public function loadUser()
    {
        $user = user();
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->avater = $user->avatar;
        $this->dateOfBirth = $user->date_of_birth;
        $this->description = $user->description;
    }
    public function render()
    {
        return view('livewire.backend.user.settings.account-settings-component');
    }
}
