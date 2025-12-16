<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Announcement;

use App\Models\CustomNotification;
use Livewire\Component;

class Show extends Component
{
    public CustomNotification $data;
    public function mount(CustomNotification $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.notification-management.announcement.show');
    }
}
