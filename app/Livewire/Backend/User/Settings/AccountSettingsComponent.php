<?php

namespace App\Livewire\Backend\User\Settings;

use Livewire\Component;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Livewire\Forms\User\UserForm;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AccountSettingsComponent extends Component
{
    use WithFileUploads, WithNotification;

    // Properties
    public $userId = null;
    public $firstName = null;
    public $lastName = null;
    public $email = null;
    public $phone = null;
    public $dateOfBirth = null;
    public $description = null;
    public $existingFile;
    public $updatedFormAvatar = null;
    public $avatarFile;

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


    public function updatedAvatarFile()
    {
        try {
            $this->validate([
                'avatarFile' => 'required|image|mimes:jpeg,png,heic|max:10240'
            ]);

            $updatedUser = $this->service->updateData(user()->id, [
                'avatar' => $this->avatarFile
            ]);

            $this->existingFile = $updatedUser->avatar;

            $this->reset('avatarFile');

            $this->success(__('Profile image updated successfully!'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('avatarFile', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('User avatar update failed', [
                'user_id' => user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->addError('avatarFile', __('Failed to update profile image'));
        }
    }
    public function updateProfile()
    {
        try {
            $validated = $this->form->validate();

            $updatedUser = $this->service->updateData(user()->id, $validated);

            $this->mount();

            $this->success(__('Profile updated successfully!'));

            $this->dispatch('profile-updated');

            return $this->redirect(route('user.account-settings'), navigate: true);
        } catch (\Exception $e) {
            Log::error('User profile update failed', [
                'user_id' => user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error(__('Profile update failed: ') . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.user.settings.account-settings-component');
    }
}
