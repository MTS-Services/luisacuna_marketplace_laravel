<?php

namespace App\Livewire\Backend\User\Settings;

use Livewire\Component;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;
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
    public $avatar;

    public bool $showModal = false;

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
        
        // Explicitly fill form data
        $this->form->fill([
            'user_id' => $user->id,
            'first_name' => $user->first_name ?? '',
            'last_name' => $user->last_name ?? '',
            'email' => $user->email ?? '',
            'username' => $user->username ?? '',
            'phone' => $user->phone ?? '',
            'date_of_birth' => $user->date_of_birth ?? '',
            'description' => $user->description ?? '',
            'account_status' => $user->account_status->value ?? 'active',
        ]);
    }

    public function updatedAvatar()
    {
        try {
            $this->validate([
                'avatar' => 'image|max:2048'
            ]);

            $path = $this->avatar->store('users', 'public');
            auth()->user()->update([
                'avatar' => $path,
            ]);
            
            $this->success(__('Profile photo updated successfully!'));
        } catch (\Exception $e) {
            $this->error(__('Profile photo update failed!'));
            Log::error('Avatar update failed', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updateProfile()
    {
        try {
            logger()->info('Form Data Before Validation:', [
                'email' => $this->form->email,
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                'all_data' => $this->form->all()
            ]);

            // Validate the form
            $validatedData = $this->form->validate();
            
            logger()->info('Validated Data:', $validatedData);

            $updatedUser = $this->service->updateData(user()->id, $validatedData);

            $this->mount();
            $this->success(__('Profile updated successfully!'));
            $this->dispatch('profile-updated');

            return $this->redirect(route('user.account-settings'), navigate: true);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            logger()->error('Validation Error:', [
                'errors' => $e->errors(),
                'form_data' => $this->form->all()
            ]);
            $this->error(__('Validation failed. Please check all fields.'));
            throw $e;
            
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