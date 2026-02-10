<?php

namespace App\Livewire\Backend\User\Notifications;

use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationSidebar extends Component
{
    use WithNotification;

    public bool $UserNotificationShow = false;
    public bool $initialized = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    #[Computed]
    public function notifications()
    {
        if (!$this->initialized) {
            return collect();
        }

        try {
            return $this->service->getRecent(10);
        } catch (\Exception $e) {
            Log::error('Failed to fetch notifications: ' . $e->getMessage());
            return collect();
        }
    }

    #[On('user-notification-show')]
    public function openSidebar(): void
    {
        $this->initialized = false;
        unset($this->notifications); // Clear cache

        $this->UserNotificationShow = true;
        $this->initialized = true;
    }

    public function closeSidebar(): void
    {
        $this->UserNotificationShow = false;
        $this->initialized = false;
        unset($this->notifications);
    }

    #[Computed]
    public function unreadCount(): int
    {
        return $this->service->getUnreadCount(null);
    }

    public function markAsRead(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->markAsRead($id);
            unset($this->notifications);
            $this->dispatch('notification-read');
        } catch (\Exception $e) {
            Log::error('Mark as read error: ' . $e->getMessage());
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $count = $this->service->markAllAsRead();
            unset($this->notifications);
            $this->dispatch('all-notifications-read');
            $this->toastSuccess(__('Marked :count notifications as read', ['count' => $count]));
        } catch (\Exception $e) {
            Log::error('Mark all as read error: ' . $e->getMessage());
            $this->toastError(__('Something went wrong.'));
        }
    }

    #[On('notification-received'), On('notification-created')]
    public function refreshNotifications(): void
    {
        if ($this->initialized) {
            unset($this->notifications);
        }
    }

    public function render()
    {
        return view('livewire.backend.user.notifications.notification-sidebar');
    }
}