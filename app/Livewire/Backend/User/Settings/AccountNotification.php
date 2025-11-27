<?php

namespace App\Livewire\Backend\User\Settings;

use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AccountNotification extends Component
{
    public bool $new_order = false;
    public bool $new_message = false;
    public bool $new_request = false;
    public bool $message_received = false;
    public bool $status_changed = false;
    public bool $request_rejected = false;
    public bool $dispute_created = false;
    public bool $payment_received = false;

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $user = user();
        
        // Get notification settings (must exist)
        $notificationSettings = $this->service->getNotificationSettings($user->id);
    
        
        $this->new_order = $notificationSettings->new_order;
        $this->new_message = $notificationSettings->new_message;
        $this->new_request = $notificationSettings->new_request;
        $this->message_received = $notificationSettings->message_received;
        $this->status_changed = $notificationSettings->status_changed;
        $this->request_rejected = $notificationSettings->request_rejected;
        $this->dispute_created = $notificationSettings->dispute_created;
        $this->payment_received = $notificationSettings->payment_received;
    }

    public function render()
    {
        return view('livewire.backend.user.settings.account-notification');
    }

    public function updated($propertyName)
    {
        try {
            // Update through UpdateNotificationAction via service 
            $this->service->updateNotificationSetting(
                user()->id,
                $propertyName,
                $this->$propertyName
            );
            $this->success('Data updated successfully.');

            $this->dispatch('profile-updated');
            
            // $this->dispatch('success', 'Notification setting updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update notification', [
                'property' => $propertyName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('error', 'Failed to update: ' . $e->getMessage());
        }
    }
}