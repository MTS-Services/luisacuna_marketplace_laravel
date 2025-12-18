<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Enums\CustomNotificationType;
use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithNotification;

    #[Url(keep: true)]
    public string $filter = 'all'; // all, unread, read

    #[Url()]
    public int $perPage = 15;

    public bool $isLoading = false;
    public array $selectedNotifications = [];
    public bool $selectAll = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    { //
    }

    #[Computed]
    public function notifications()
    {
        return $this->service->getAll(
            state: $this->filter,
            type: null,
            perPage: $this->perPage
        );
    }

    #[Computed]
    public function stats(): array
    {
        return $this->service->getStats(null);
    }

    #[Computed]
    public function unreadCount(): int
    {
        return $this->service->getUnreadCount(null);
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
        $this->selectedNotifications = [];
        $this->selectAll = false;
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedNotifications = $this->notifications->pluck('id')->toArray();
        } else {
            $this->selectedNotifications = [];
        }
    }

    public function markAsRead(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->markAsRead($id);
            $this->dispatch('notification-read');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to mark notification as read');
        }
    }

    public function markAsUnread(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->markAsUnread($id);
            $this->success('Notification marked as unread');
            $this->dispatch('notification-unread');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to mark notification as unread');
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $count = $this->service->markAllAsRead(null);

            $this->success("Marked {$count} notifications as read");
            $this->dispatch('all-notifications-read');
            $this->selectedNotifications = [];
            $this->selectAll = false;
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to mark all notifications as read');
        }
    }

    public function deleteNotification(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->delete($id);
            $this->toastSuccess('Notification deleted successfully');
            $this->dispatch('notification-deleted');
            $this->selectedNotifications = array_diff($this->selectedNotifications, [$id]);
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to delete notification');
        }
    }

    public function deleteSelected(): void
    {
        if (empty($this->selectedNotifications)) {
            $this->warning('No notifications selected');
            return;
        }

        try {
            $count = $this->service->deleteMany($this->selectedNotifications);
            $this->toastSuccess("Deleted {$count} notifications");
            $this->dispatch('notifications-deleted');
            $this->selectedNotifications = [];
            $this->selectAll = false;
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to delete selected notifications');
        }
    }

    public function deleteAll(): void
    {
        try {
            $count = $this->service->deleteAll(null);

            $this->toastSuccess("Deleted {$count} notifications");
            $this->dispatch('all-notifications-deleted');
            $this->selectedNotifications = [];
            $this->selectAll = false;
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error('Failed to delete all notifications');
        }
    }

    public function refresh(): void
    {
        $this->resetPage();
        unset($this->notifications);
        $this->success('Notifications Refreshed');
    }

    #[On('notification-created')]
    #[On('notification-updated')]
    #[On('notification-received')]
    public function refreshNotifications(): void
    {
        unset($this->notifications);
    }

    public function getListeners(): array
    {
        return [
            'notification-created' => 'refreshNotifications',
            'notification-updated' => 'refreshNotifications',
            'notification-received' => 'refreshNotifications',
        ];
    }

    public function render()
    {
        return view('livewire.backend.admin.notification-management.notification.index');
    }
}
