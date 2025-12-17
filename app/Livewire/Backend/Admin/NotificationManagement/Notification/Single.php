<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Models\CustomNotification;
use Livewire\Component;

class Single extends Component
{

    public CustomNotification $notification;

    public function render()
    {
        return view('livewire.backend.admin.notification-management.notification.single');
    }
}
