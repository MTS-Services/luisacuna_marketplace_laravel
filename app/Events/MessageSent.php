<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue = 'broadcasts'; // Use dedicated queue for broadcasts

    /**
     * Create a new event instance.
     */
    public function __construct(public Message $message)
    {
        // Eager load relationships to avoid N+1 queries
        $this->message->load(['sender', 'attachments']);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.' . $this->message->conversation_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'sender_type' => $this->message->sender_type,
            'message_body' => $this->message->message_body,
            'message_type' => $this->message->message_type->value ?? $this->message->message_type,
            'created_at' => $this->message->created_at->toISOString(),
            'sender' => $this->message->sender ? [
                'id' => $this->message->sender->id,
                'full_name' => $this->message->sender->full_name ?? $this->message->sender->name,
                'avatar' => $this->message->sender->avatar,
            ] : null,
            'attachments' => $this->message->attachments->map(fn($att) => [
                'id' => $att->id,
                'attachment_type' => $att->attachment_type->value ?? $att->attachment_type,
                'file_path' => $att->file_path,
                'thumbnail_path' => $att->thumbnail_path,
            ])->toArray(),
        ];
    }
}
