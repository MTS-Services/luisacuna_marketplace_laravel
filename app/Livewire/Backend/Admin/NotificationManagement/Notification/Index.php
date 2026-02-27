<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithNotification;

    #[Url(keep: true)]
    public string $filter = 'all'; // all | unread | read

    #[Url]
    public int $perPage = 15;

    public array $selectedNotifications = [];
    public bool  $selectAll             = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    /* ═══════════════════════════════════════
     |  Property Watchers
     ═══════════════════════════════════════ */

    public function updatedFilter(): void
    {
        $this->resetPage();
        $this->selectedNotifications = [];
        $this->selectAll             = false;
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedNotifications = $this->service
                ->getAll(state: $this->filter, type: null, perPage: $this->perPage)
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedNotifications = [];
        }
    }

    /* ═══════════════════════════════════════
     |  Actions
     |
     |  Methods receive the raw notification UUID directly.
     |  Encryption is NOT used here — encrypted values change on
     |  every render (new random IV), which breaks wire:target matching
     |  after the first action. Raw UUIDs are stable across renders,
     |  so wire:target="markAsRead('uuid')" always matches wire:click.
     |
     |  The service already scopes every query to the authenticated actor,
     |  so passing a UUID the actor doesn't own simply returns no result.
     ═══════════════════════════════════════ */

    public function markAsRead(string $id): void
    {
        try {
            $this->service->markAsRead(notificationId: $id, actorType: 'admin');
            $this->toastSuccess('Notification marked as read');
            $this->dispatch('notification-read');
        } catch (\Exception) {
            $this->error('Failed to mark notification as read');
        }
    }

    public function markAsUnread(string $id): void
    {
        try {
            $this->service->markAsUnread(notificationId: $id, actorType: 'admin');
            $this->toastSuccess('Notification marked as unread');
            $this->dispatch('notification-unread');
        } catch (\Exception) {
            $this->error('Failed to mark notification as unread');
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $count = $this->service->markAllAsRead(actorType: 'admin');
            $this->toastSuccess("Marked {$count} notifications as read");
            $this->dispatch('all-notifications-read');
            $this->selectedNotifications = [];
            $this->selectAll             = false;
        } catch (\Exception) {
            $this->error('Failed to mark all notifications as read');
        }
    }

    public function deleteNotification(string $id): void
    {
        try {
            $this->service->delete(notificationId: $id, actorType: 'admin');
            $this->toastSuccess('Notification deleted');
            $this->dispatch('notification-deleted');
            $this->selectedNotifications = array_values(
                array_diff($this->selectedNotifications, [$id])
            );
        } catch (\Exception) {
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
            $count = $this->service->deleteMany(notificationIds: $this->selectedNotifications, actorType: 'admin');
            $this->toastSuccess("Deleted {$count} notifications successfully");
            $this->dispatch('notifications-deleted');
            $this->selectedNotifications = [];
            $this->selectAll             = false;
        } catch (\Exception) {
            $this->error('Failed to delete selected notifications');
        }
    }

    public function deleteAll(): void
    {
        try {
            $count = $this->service->deleteAll(actorType: 'admin');
            $this->toastSuccess("Deleted {$count} notifications");
            $this->dispatch('all-notifications-deleted');
            $this->selectedNotifications = [];
            $this->selectAll             = false;
        } catch (\Exception) {
            $this->error('Failed to delete all notifications');
        }
    }

    public function refresh(): void
    {
        $this->resetPage();
        $this->success('Notifications Refreshed');
    }

    /* ═══════════════════════════════════════
     |  Event Listeners
     ═══════════════════════════════════════ */

    #[On('notification-created')]
    #[On('notification-updated')]
    #[On('notification-received')]
    public function refreshNotifications(): void
    {
        // render() always fetches fresh data — a re-render is all we need.
    }

    /* ═══════════════════════════════════════
     |  Render
     ═══════════════════════════════════════ */

    public function render()
    {
        $notifications = $this->service->getAll(
            state: $this->filter,
            type: null,
            perPage: $this->perPage,
            actorType: 'admin'
        );

        $stats       = $this->service->getStats(actorType: 'admin');
        $unreadCount = $this->service->getUnreadCount(receiverType: 'admin');

        return view('livewire.backend.admin.notification-management.notification.index', [
            'notifications' => $notifications,
            'stats'         => $stats,
            'unreadCount'   => $unreadCount,
        ]);
    }
}
