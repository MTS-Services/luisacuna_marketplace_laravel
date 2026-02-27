<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Models\CustomNotification;
use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Single extends Component
{
    use WithNotification;

    public ?string $encryptedId = null;

    public ?CustomNotification $notification = null;

    public bool $notFound = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    public function mount(string $encryptedId): void
    {
        $this->encryptedId = $encryptedId;

        try {
            $id = decrypt($encryptedId);

            $notification = $this->service->find($id);

            if (! $notification) {
                $this->notFound = true;
                return;
            }

            $this->notification = $notification;

            // Auto-mark as read when the page is opened
            $this->service->markAsRead($id);
        } catch (\Throwable) {
            $this->notFound = true;
        }
    }

    /* ═══════════════════════════════════════
     |  Actions
     ═══════════════════════════════════════ */

    public function markAsUnread(): void
    {
        if (! $this->notification) {
            return;
        }

        try {
            $this->service->markAsUnread($this->notification->id);
            $this->dispatch('notification-updated');
            $this->redirect(route('admin.notification.index'), navigate: true);
        } catch (\Throwable) {
            $this->error('Failed to mark notification as unread');
        }
    }

    public function deleteNotification(): void
    {
        if (! $this->notification) {
            return;
        }

        try {
            $this->service->delete($this->notification->id);
            $this->dispatch('notification-deleted');
            $this->redirect(route('admin.notification.index'), navigate: true);
        } catch (\Throwable) {
            $this->error('Failed to delete notification');
        }
    }

    /* ═══════════════════════════════════════
     |  Render
     ═══════════════════════════════════════ */

    public function render()
    {
        return view('livewire.backend.admin.notification-management.notification.single');
    }
}
