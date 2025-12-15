<?php

namespace App\Events;

use App\Enums\CustomNotificationType;
use App\Models\CustomNotification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotificationSent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CustomNotification $notification;

    public function __construct(CustomNotification $notification)
    {
        $this->notification = $notification;
    }


    public function broadcastOn()
    {
        if ($this->notification->receiver_id && $this->notification->receiver_type == User::class) {
            return new PrivateChannel('user.' . $this->notification->receiver_id);
        } elseif ($this->notification->receiver_id == null && ($this->notification->type == CustomNotificationType::USER->value || $this->notification->type == CustomNotificationType::PUBLIC->value)) {
            return new Channel('users');
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
            'action' => $this->notification->action ?? null,
            'icon' => $this->notification->data['icon'] ?? 'bell',
            'additional' => $this->notification->additional ?? null,
            'timestamp' => dateTimeHumanFormat(now()),
        ];
    }
}
