<?php

namespace App\Events;

use App\Enums\CustomNotificationType;
use App\Models\Admin;
use App\Models\CustomNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationSent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CustomNotification $notification;

    public function __construct(CustomNotification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        if ($this->notification->receiver_id && $this->notification->receiver_type == Admin::class) {
            return new PrivateChannel('admin.' . $this->notification->receiver_id);
        } elseif ($this->notification->receiver_id == null && ($this->notification->type == CustomNotificationType::ADMIN->value || $this->notification->type == CustomNotificationType::PUBLIC->value)) {
            return new Channel('admins');
        }
        return [];
    }
    public function broadcastAs()
    {
        return 'notification.sent';
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->notification->data['title'],
            'message' => $this->notification->data['message'] ?? null,
            'description' => $this->notification->data['description'] ?? null,
            'url' => $this->notification->action ?? null,
            'icon' => $this->notification->data['icon'] ?? 'cog',
            'additional_data' => $this->notification->data['additional_data'],
            'timestamp' => dateTimeHumanFormat(now()),
        ];
    }
}
