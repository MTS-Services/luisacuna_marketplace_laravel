<?php

namespace App\Http\Controllers\Backend\Admin\ChatManagement;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    protected string $masterView = 'backend.admin.pages.chat-management.chat';

    public function index()
    {
        return view($this->masterView);
    }
    // public function chat(string $id)
    // {
    //     // Find conversation by ID
    //     $conversation = Conversation::with(['conversation_participants.user', 'messages'])
    //         ->find($id);

    //     if (!$conversation) {
    //         abort(404, 'Conversation not found');
    //     }

    //     // Prepare data object to pass to view
    //     $data = (object) [
    //         'conversation_id' => $conversation->id,
    //         'conversation' => $conversation
    //     ];

    //     return view($this->masterView, [
    //         'data' => $data
    //     ]);
    // }

public function chat(string $id)
    {
        // Verify conversation exists
        $conversation = Conversation::findOrFail($id);
        
        return view($this->masterView, [
            'conversationId' => $id
        ]);
    }
}
