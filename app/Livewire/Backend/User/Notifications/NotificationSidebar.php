<?php

namespace App\Livewire\Backend\User\Notifications;

use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationSidebar extends Component
{
    use WithNotification;

    public bool $UserNotificationShow = false;
    public Collection $notifications;
    public bool $isLoading = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->notifications = new Collection();
    }

    public function render()
    {
        return view('livewire.backend.user.notifications.notification-sidebar');
    }

    #[On('user-notification-show')]
    public function openSidebar(): void
    {
        $this->UserNotificationShow = true;
        $this->fetchNotifications();
    }

    public function fetchNotifications(): void
    {
        try {
            $this->isLoading = true;
            $this->notifications = $this->service->getRecent(10);
        } catch (\Exception $e) {
            Log::error('Failed to fetch notifications', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $this->notifications = new Collection();
        } finally {
            $this->isLoading = false;
        }
    }

    public function markAsRead(string $id): void
    {
        try {
            $this->service->markAsRead($id);
            $this->fetchNotifications();
            $this->dispatch('notification-read');
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $count = $this->service->markAllAsRead();
            $this->fetchNotifications();
            $this->dispatch('all-notifications-read');
            $this->toastSuccess(__('Marked :count notifications as read', ['count' => $count]));
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read', [
                'error' => $e->getMessage(),
            ]);
            $this->toastError(__('Something went wrong. Please try again.'));
        }
    }

    #[On('notification-received')]
    #[On('notification-created')]
    public function refreshNotifications(): void
    {
        if ($this->UserNotificationShow) {
            $this->fetchNotifications();
        }
    }

    public function getListeners(): array
    {
        return [
            'user-notification-show' => 'openSidebar',
            'notification-received' => 'refreshNotifications',
            'notification-created' => 'refreshNotifications',
        ];
    }
}