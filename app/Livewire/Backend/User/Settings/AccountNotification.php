<?php

namespace App\Livewire\Backend\User\Settings;

use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AccountNotification extends Component
{
    public array $settings = [
        'new_order' => false,
        'new_message' => false,
        'order_update' => false,
        'dispute_update' => false,
        'payment_update' => false,
        'withdrawal_update' => false,
        'verification_update' => false,
        'boosting_offer' => false,
    ];

    public bool $all_notifications = false;

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $notificationSettings = user()->notificationSetting;

        if ($notificationSettings) {
            foreach (array_keys($this->settings) as $key) {
                $this->settings[$key] = (bool) $notificationSettings->$key;
            }
        }

        $this->checkIfAllEnabled();
    }

    public function updated($propertyName, $value)
    {
        try {
            if ($propertyName === 'all_notifications') {
                $this->toggleAll($value);
            } else {
                $actualKey = str_replace('settings.', '', $propertyName);

                // Update specific database field
                $this->service->updateNotificationSettings(user()->id, [
                    $actualKey => $value
                ]);

                $this->checkIfAllEnabled();
            }
        } catch (\Exception $e) {
            Log::error('Failed to update settings: ' . $e->getMessage());
        }
    }

    private function toggleAll(bool $status)
    {
        // Update local state
        foreach ($this->settings as $key => $val) {
            $this->settings[$key] = $status;
        }

        // Mass update database
        $this->service->updateNotificationSettings(user()->id, $this->settings);
    }

    private function checkIfAllEnabled()
    {
        // If any setting is false, the master toggle must be false
        $this->all_notifications = !in_array(false, $this->settings, true);
    }

    public function render()
    {
        return view('livewire.backend.user.settings.account-notification');
    }
}
