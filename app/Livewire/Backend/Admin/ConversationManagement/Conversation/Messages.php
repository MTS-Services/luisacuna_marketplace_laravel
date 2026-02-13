<?php

namespace App\Livewire\Backend\Admin\ConversationManagement\Conversation;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Services\Cloudinary\CloudinaryService;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Messages extends Component
{
    use WithFileUploads;

    public ?int          $conversationId = null;
    public ?Conversation $conversation   = null;
    public array         $messages       = [];
    public string        $message        = '';
    public               $media          = null;
    public bool          $isLoading      = false;
    public ?int          $beforeMessageId = null;
    public bool          $hasJoined      = false;

    protected ConversationService $service;
    protected CloudinaryService   $cloudinaryService;

    protected function rules(): array
    {
        return [
            'message' => 'nullable|string|max:5000',
            'media'   => 'nullable',
            'media.*' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,heic,svg,gif,mp4,mkv,mov,webm,mp3,aac,ogg,wav,pdf,doc,docx',
            ],
        ];
    }

    public function boot(ConversationService $service, CloudinaryService $cloudinaryService): void
    {
        $this->service           = $service;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function mount(?int $conversationId = null): void
    {
        if ($conversationId) {
            $this->loadConversation($conversationId);
        }
    }

    #[On('admin-conversation-selected')]
    public function loadConversation(int $conversationId): void
    {
        if ($this->conversationId === $conversationId && $this->conversation) {
            return;
        }

        $this->conversationId = $conversationId;

        $this->conversation = Conversation::select('id', 'conversation_uuid', 'subject', 'status', 'last_message_at')
            ->with(['participants' => function ($query) {
                $query->where('is_active', true)
                    ->with(['participant' => function ($q) {
                        $q->select('id', 'first_name', 'last_name', 'username', 'email', 'avatar');
                    }]);
            }])
            ->find($conversationId);

        $this->loadMessages();

        // Check if admin already participant
        $this->hasJoined = $this->conversation->participants()
            ->where('participant_id', Auth::guard('admin')->id())
            ->where('participant_type', \App\Models\Admin::class)
            ->where('is_active', true)
            ->exists();

        $this->dispatch('admin-conversation-loaded', conversationId: $conversationId);
    }

    public function loadMessages(): void
    {
        if (!$this->conversation) {
            $this->messages = [];
            return;
        }

        $result = $this->service->fetchConversationMessagesForAdmin(
            $this->conversation,
            perPage: 50,
            beforeMessageId: $this->beforeMessageId
        );

        if ($result) {
            $this->messages = $result['messages']->reverse()->values()->all();
        }
    }

    public function joinConversation(): void
    {
        if (!$this->conversation) {
            return;
        }

        $admin = Auth::guard('admin')->user();
        $participant = $this->service->adminJoinConversation($this->conversation, $admin);

        if ($participant) {
            $this->hasJoined = true;
            $this->loadMessages();
            $this->dispatch('success', message: 'You have joined the conversation');
            $this->dispatch('refresh-admin-conversations');
        } else {
            $this->dispatch('error', message: 'Failed to join conversation');
        }
    }

    public function sendMessage(): void
    {
        if (!$this->conversation) {
            $this->dispatch('error', message: 'No conversation selected');
            return;
        }

        if (!$this->hasJoined) {
            $this->joinConversation();
        }

        $trimmed = trim($this->message);

        if (empty($trimmed) && !$this->media) {
            return;
        }

        // Validate
        if ($this->media) {
            try {
                $this->validate();
            } catch (\Illuminate\Validation\ValidationException $e) {
                $firstError = collect($e->errors())->flatten()->first();
                $this->dispatch('error', message: $firstError ?? 'Invalid file');
                return;
            }
        }

        $this->isLoading = true;

        try {
            $attachments = [];

            if ($this->media) {
                $files = is_array($this->media) ? $this->media : [$this->media];
                foreach ($files as $file) {
                    $attachments[] = $this->uploadFile($file);
                }
            }

            // Determine message type
            $messageType = MessageType::TEXT;
            if (!empty($attachments)) {
                $firstType = $attachments[0]['type'] ?? null;
                if ($firstType instanceof AttachmentType) {
                    $messageType = match ($firstType) {
                        AttachmentType::IMAGE => MessageType::IMAGE,
                        AttachmentType::VIDEO => MessageType::VIDEO,
                        AttachmentType::AUDIO => MessageType::AUDIO,
                        default               => MessageType::FILE,
                    };
                }
            }

            $admin = Auth::guard('admin')->user();

            $sentMessage = $this->service->adminSendMessage(
                conversation: $this->conversation,
                admin: $admin,
                messageBody: $trimmed,
                messageType: $messageType,
                attachments: $attachments
            );

            if ($sentMessage) {
                $sentMessage->load([
                    'sender:id,name,email,avatar',
                    'attachments',
                ]);

                $this->messages[] = $sentMessage;
                $this->message    = '';
                $this->media      = null;

                $this->dispatch('refresh-admin-conversations');
                $this->dispatch('scroll-to-bottom');
                $this->dispatch('reset-admin-textarea');
            } else {
                $this->dispatch('error', message: 'Failed to send message');
            }
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    protected function uploadFile($file): array
    {
        $uploaded = $this->cloudinaryService->upload($file, ['folder' => 'chats/admin']);
        $path     = $uploaded->publicId;
        $mime     = $file->getMimeType();

        $type = AttachmentType::FILE;
        if (str_starts_with($mime, 'image/')) {
            $type = AttachmentType::IMAGE;
        } elseif (str_starts_with($mime, 'video/')) {
            $type = AttachmentType::VIDEO;
        } elseif (str_starts_with($mime, 'audio/')) {
            $type = AttachmentType::AUDIO;
        }

        return ['type' => $type, 'path' => $path, 'thumbnail' => null];
    }

    #[On('new-message-received-admin')]
    public function handleNewMessageReceived(array $messageData): void
    {
        if (!$this->conversation || $messageData['conversation_id'] != $this->conversationId) {
            return;
        }

        $newMessage = \App\Models\Message::with(['sender', 'attachments'])
            ->find($messageData['id']);

        if ($newMessage) {
            $this->messages[] = $newMessage;
            $this->dispatch('check-scroll-position-admin');
        }
    }

    public function loadMoreMessages(): void
    {
        if (empty($this->messages)) {
            return;
        }

        $oldest = collect($this->messages)->first();
        $this->beforeMessageId = $oldest->id ?? null;

        if ($this->beforeMessageId) {
            $result = $this->service->fetchConversationMessagesForAdmin(
                $this->conversation,
                perPage: 50,
                beforeMessageId: $this->beforeMessageId
            );

            if ($result && $result['messages']->isNotEmpty()) {
                $older = $result['messages']->reverse()->values()->all();
                $this->messages = array_merge($older, $this->messages);
                $this->dispatch('maintain-scroll-position-admin');
            }
        }
    }

    public function deleteMessage(int $messageId): void
    {
        try {
            $message = \App\Models\Message::find($messageId);

            if ($message) {
                $admin = Auth::guard('admin')->user();

                // Create a User instance wrapper for the admin (since deleteMessage expects User)
                // Or we can check if admin can delete
                if ($message->delete()) {
                    $this->messages = collect($this->messages)
                        ->reject(fn($msg) => $msg->id === $messageId)
                        ->values()->all();
                    $this->dispatch('success', message: 'Message deleted');
                } else {
                    $this->dispatch('error', message: 'Failed to delete message');
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error deleting message');
        }
    }

    public function removeMedia(int $index): void
    {
        if (is_array($this->media)) {
            $arr = $this->media;
            array_splice($arr, $index, 1);
            $this->media = empty($arr) ? null : array_values($arr);
        } else {
            $this->media = null;
        }
    }

    public function getParticipantsProperty()
    {
        if (!$this->conversation) {
            return collect();
        }

        return $this->conversation->participants->map(function ($participant) {
            $p = $participant->participant;
            return [
                'id'       => $participant->participant_id,
                'type'     => $participant->participant_type,
                'role'     => $participant->participant_role,
                'name'     => $p?->full_name ?? $p?->name ?? 'Unknown',
                'avatar'   => $p?->avatar,
                'is_admin' => $participant->participant_type === \App\Models\Admin::class,
            ];
        });
    }

    public function render()
    {
        return view('livewire.backend.admin.conversation-management.conversation.messages', [
            'participants' => $this->participants,
        ]);
    }
}
