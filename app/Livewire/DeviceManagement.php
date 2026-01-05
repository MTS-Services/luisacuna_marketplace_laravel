<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class DeviceManagement extends Component
{
    public $devices = [];
    public $showConfirmModal = false;
    public $actionType = null;
    public $selectedDeviceId = null;
    public $authorized = null;


    public function mount()
    {
        $user = Auth::guard('web')->user();
        $admin = Auth::guard('admin')->user();
        if (!$user && !$admin) {
            Log::warning('Unauthorized access to device management. Redirecting to login page.');
            return $this->redirectIntended(
                default: route('login'),
                navigate: true
            );
        }


        $this->authorized = $admin ? $admin : $user;
        $this->loadDevices();
    }

    public function loadDevices()
    {
        $this->devices = $this->authorized
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

        $device = $this->authorized->devices()->find($this->selectedDeviceId);

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

        if ($this->authorized->logoutDevice($this->selectedDeviceId)) {
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
        $count = $this->authorized->logoutAllDevices(includingCurrent: false);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Successfully logged out from {$count} device(s)."
        ]);

        $this->loadDevices();
        $this->resetModal();
    }

    public function removeDevice($deviceId)
    {
        $device = $this->authorized->devices()->find($deviceId);

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

        if ($this->authorized->removeDevice($deviceId)) {
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
