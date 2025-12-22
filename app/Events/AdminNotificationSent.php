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
use Illuminate\Support\Facades\Log;

class AdminNotificationSent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CustomNotification $notification;

    public $queue = 'broadcasts';

    public function __construct(CustomNotification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        Log::info('Called Admin notification.');
        Log::info('AdminNotificationSent - broadcastOn called', [
            'notification_id' => $this->notification->id,
            'receiver_id' => $this->notification->receiver_id,
            'receiver_type' => $this->notification->receiver_type,
            'type' => $this->notification->type,
            'type_is_admin' => $this->notification->type == CustomNotificationType::ADMIN,
            'type_is_public' => $this->notification->type == CustomNotificationType::PUBLIC,
        ]);
        if ($this->notification->receiver_id && $this->notification->receiver_type == Admin::class) {
            Log::info('Broadcasting admin notification' . $this->notification->id);
            return new PrivateChannel('admin.' . $this->notification->receiver_id);
        } elseif ($this->notification->receiver_id == null && ($this->notification->type == CustomNotificationType::ADMIN || $this->notification->type == CustomNotificationType::PUBLIC)) {
            Log::info('Broadcasting public notification for admins ' . $this->notification->id);
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
            'icon' => $this->notification->data['icon'] ?? 'bell',
            'additional' => $this->notification->additional ?? [],
            'timestamp' => dateTimeHumanFormat(now()),
        ];
    }
}
