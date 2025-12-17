<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    use WithNotification;

    public bool $openSidebarNotifications = false;
    public Collection $notifications;
    public bool $isLoading = true;

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
        return view('livewire.backend.admin.notification-management.notification.sidebar');
    }

    #[On('open-sidebar-notifications')]
    public function openSidebar(): void
    {
        $this->openSidebarNotifications = true;
        $this->fetchNotifications();
    }

    #[On('close-sidebar-notifications')]
    public function closeSidebar(): void
    {
        $this->openSidebarNotifications = false;
    }

    #[On('notification-received')]
    #[On('notification-created')]
    #[On('notification-updated')]
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
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $this->toastError(__('Something went wrong. Please try again.'));
        }
    }

    public function getListeners(): array
    {
        return [
            'open-sidebar-notifications' => 'openSidebar',
            'close-sidebar-notifications' => 'closeSidebar',
            'notification-received' => 'fetchNotifications',
            'notification-created' => 'fetchNotifications',
            'notification-updated' => 'fetchNotifications',
        ];
    }
}
