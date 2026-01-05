<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class DeviceManagement extends Component
{
    public $devices = [];
    public $showConfirmModal = false;
    public $actionType = null;
    public $selectedDeviceId = null;

    public function mount()
    {
        $this->loadDevices();
    }

    public function loadDevices()
    {
        $this->devices = user()
            ->devices()
            ->orderBy('last_used_at', 'desc')
            ->get()
            ->map(function ($device) {
                return [
                    'id' => $device->id,
                    'device_info' => $device->device_info,
                    'device_type' => $device->device_type,
                    'ip_address' => $device->ip_address,
                    'last_used_at' => $device->last_used_at?->diffForHumans(),
                    'is_current' => $device->is_current_device,
                    'is_active' => $device->is_active,
                    'created_at' => $device->created_at->format('M d, Y h:i A'),
                ];
            })
            ->toArray();
    }

    public function confirmLogoutDevice($deviceId)
    {
        $this->selectedDeviceId = $deviceId;
        $this->actionType = 'single';
        $this->showConfirmModal = true;
    }

    public function confirmLogoutAllDevices()
    {
        $this->actionType = 'all';
        $this->showConfirmModal = true;
    }

    public function logoutDevice()
    {
        if (!$this->selectedDeviceId) {
            return;
        }

        $device = user()->devices()->find($this->selectedDeviceId);

        if (!$device) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Device not found.'
            ]);
            return;
        }

        if ($device->is_current_device) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'You cannot logout from the current device. Use the main logout button instead.'
            ]);
            return;
        }

        if (user()->logoutDevice($this->selectedDeviceId)) {
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Device logged out successfully.'
            ]);

            $this->loadDevices();
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to logout device.'
            ]);
        }

        $this->resetModal();
    }

    public function logoutAllDevices()
    {
        $count = user()->logoutAllDevices(includingCurrent: false);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Successfully logged out from {$count} device(s)."
        ]);

        $this->loadDevices();
        $this->resetModal();
    }

    public function removeDevice($deviceId)
    {
        $device = user()->devices()->find($deviceId);

        if (!$device) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Device not found.'
            ]);
            return;
        }

        if ($device->is_current_device) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'You cannot remove the current device.'
            ]);
            return;
        }

        if (user()->removeDevice($deviceId)) {
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Device removed successfully.'
            ]);

            $this->loadDevices();
        }
    }

    public function executeAction()
    {
        if ($this->actionType === 'all') {
            $this->logoutAllDevices();
        } elseif ($this->actionType === 'single') {
            $this->logoutDevice();
        }
    }

    public function resetModal()
    {
        $this->showConfirmModal = false;
        $this->actionType = null;
        $this->selectedDeviceId = null;
    }

    #[On('refresh-devices')]
    public function refresh()
    {
        $this->loadDevices();
    }

    public function render()
    {
        return view('livewire.device-management');
    }
}
