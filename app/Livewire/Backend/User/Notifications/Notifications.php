<?php

namespace App\Livewire\Backend\User\Notifications;

use App\Enums\CustomNotificationType;
use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination, WithNotification;

    #[Url(keep: true)]
    public string $filter = 'all'; // all, unread, read

    #[Url()]
    public int $perPage = 15;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        // Optional: Add authorization check if needed
        // $this->authorize('viewAny', \App\Models\CustomNotification::class);
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
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function markAsRead(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->markAsRead($id);
            $this->dispatch('notification-read');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error(__('Failed to mark notification as read'));
        }
    }

    public function markAsUnread(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->markAsUnread($id);
            $this->dispatch('notification-unread');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error(__('Failed to mark notification as unread'));
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $count = $this->service->markAllAsRead(null);
            $this->success(__("Marked {$count} notifications as read"));
            $this->dispatch('all-notifications-read');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error(__('Failed to mark all notifications as read'));
        }
    }

    public function deleteNotification(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->delete($id);
            $this->toasSuccess(__('Notification deleted successfully'));
            $this->dispatch('notification-deleted');
            unset($this->notifications);
        } catch (\Exception $e) {
            $this->error(__('Failed to delete notification'));
        }
    }

    public function refresh(): void
    {
        unset($this->notifications);
        $this->success(__('Notifications refreshed'));
    }

    #[On('notification-created')]
    #[On('notification-updated')]
    #[On('notification-received')]
    public function refreshNotifications(): void
    {
        unset($this->notifications);
    }

    public function render()
    {
        return view('livewire.backend.user.notifications.notifications');
    }
}
