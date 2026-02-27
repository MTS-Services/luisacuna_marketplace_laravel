<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Announcement;

use App\Models\CustomNotification;
use App\Services\NotificationService;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?CustomNotification $data = null;

    public bool $isLoading = false;

    public bool $hasData = false; // <-- new

    public bool $announcementDetailModalShow = false;

    protected NotificationService $service;

    public function boot(NotificationService $service): void
    {
        $this->service = $service;
    }

    #[On('announcement-detail-modal-open')]
    public function fetchAnnouncementDetail(string $encryptedId): void
    {
        $this->isLoading = true;
        $this->hasData = false; // reset on each open

        try {
            $id = decrypt($encryptedId);

            $notification = $this->service->find($id);

            if (! $notification) {
                $this->data = null;
                $this->hasData = false;
                $this->isLoading = false;
                return;
            }

            // Load sender & receiver first
            $notification->loadMissing(['sender', 'receiver']);

            // Only load role if that model actually has the relationship
            if ($notification->sender && method_exists($notification->sender, 'role')) {
                $notification->sender->loadMissing('role');
            }

            if ($notification->receiver && method_exists($notification->receiver, 'role')) {
                $notification->receiver->loadMissing('role');
            }

            $this->data = $notification;
            $this->hasData = true;

            $this->service->markAsRead(notificationId: $id, actorType: 'admin');

            $this->announcementDetailModalShow = true;
        } catch (\Throwable) {
            $this->data = null;
            $this->hasData = false;
            $this->announcementDetailModalShow = false;
        } finally {
            $this->isLoading = false;
        }
    }

    public function closeModal(): void
    {
        $this->reset(['announcementDetailModalShow', 'isLoading', 'hasData', 'data']);
    }

    public function render()
    {
        return view('livewire.backend.admin.notification-management.announcement.show');
    }
}
