<?php

namespace App\Livewire\Backend\Admin\ChatManagement;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Log;
use App\Services\OrderMessageService;
use App\Traits\Livewire\WithNotification;

class Chat extends Component
{
    use WithNotification;

    public $conversationId;
    public $conversation;
    public $messages = [];
    public $messageBody = '';
    public $participant1;
    public $participant2;

    protected OrderMessageService $service;

    protected $rules = [
        'messageBody' => 'required|string|max:5000',
    ];

    public function boot(OrderMessageService $service)
    {
        $this->service = $service;
    }

    public function mount($data = null)
    {
        if ($data && isset($data->conversation_id)) {
            $this->conversationId = $data->conversation_id;
        } elseif (is_numeric($data)) {
            $this->conversationId = $data;
        } else {
            $this->conversationId = request()->route('id');
        }

        if (!$this->conversationId) {
            abort(404, 'Conversation not found');
        }

        $this->loadConversation();
        $this->loadMessages();
    }

    public function loadConversation()
    {
        $this->conversation = Conversation::with(['conversation_participants.user'])
            ->findOrFail($this->conversationId);

        $participants = $this->conversation->conversation_participants;

        $this->participant1 = $participants->get(0)?->user;
        $this->participant2 = $participants->get(1)?->user;
    }

    public function loadMessages()
    {
        $this->messages = $this->service->fetchForAdmin($this->conversationId);
    }
    public function sendMessage()
    {
        try {
            $this->service->send(
                conversationId: $this->conversationId,
                messageBody: $this->messageBody,
                messageType: \App\Enums\MessageType::TEXT
            );

            // ✅ SUCCESS LOG
            Log::info('Message sent', [
                'conversation_id' => $this->conversationId,
                'sender_id'       => auth()->id(),
                'message'         => $this->messageBody,
                'type'            => 'TEXT',
            ]);

            $this->messageBody = '';
            $this->loadMessages();

            $this->showNotification('Message sent successfully!', 'success');
            $this->dispatch('message-sent');
        } catch (\Exception $e) {

            // ❌ ERROR LOG
            Log::error('Message sending failed', [
                'conversation_id' => $this->conversationId,
                'sender_id'       => auth()->id(),
                'message'         => $this->messageBody,
                'error'           => $e->getMessage(),
            ]);

            // optional
            // $this->showNotification('Failed to send message', 'error');
        }
    }

    // public function sendMessage()
    // {
    //     // $this->validate();

    //     try {
    //         $this->service->send(
    //             conversationId: $this->conversationId,
    //             messageBody: $this->messageBody,
    //             messageType: \App\Enums\MessageType::TEXT
    //         );

    //         $this->messageBody = '';
    //         $this->loadMessages();

    //         $this->showNotification('Message sent successfully!', 'success');
    //         $this->dispatch('message-sent');

    //     } catch (\Exception $e) {
    //         // $this->showNotification('Failed to send message: ' . $e->getMessage(), 'error');
    //     }
    // }

    public function render()
    {
        return view('livewire.backend.admin.chat-management.chat');
    }
}
