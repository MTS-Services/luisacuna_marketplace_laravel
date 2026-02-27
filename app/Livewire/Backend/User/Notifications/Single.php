<?php

namespace App\Livewire\Backend\User\Notifications;

use App\Models\CustomNotification;
use App\Services\NotificationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
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

            $this->service->markAsRead(notificationId: $id, actorType: 'user');
        } catch (\Throwable) {
            $this->notFound = true;
        }
    }

    public function render()
    {
        return view('livewire.backend.user.notifications.single');
    }

    public function deleteNotification(string $encryptedId): void
    {
        $id = decrypt($encryptedId);
        try {
            $this->service->delete(notificationId: $id, actorType: 'user');

            $this->success(__('Notification deleted successfully'));
            $this->dispatch('notification-deleted');
            $this->redirect(route('user.notifications'));
        } catch (\Throwable $e) {
            $this->error(__('Failed to delete notification'));
            Log::error('Failed to delete notification', $e->getMessage());
            $this->redirect(route('user.notifications'));
        }
    }
}
