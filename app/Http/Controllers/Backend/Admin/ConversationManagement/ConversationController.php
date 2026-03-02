<?php

namespace App\Http\Controllers\Backend\Admin\ConversationManagement;

use App\Http\Controllers\Controller;
use App\Services\ConversationService;

class ConversationController extends Controller
{
    protected string $masterView = 'backend.admin.pages.conversation-management.conversation';

    public function __construct(protected ConversationService $conversationService) {}

    public function index()
    {
        return view($this->masterView);
    }

    public function show(string $conversationUuid)
    {
        $conversation = $this->conversationService->findConversation($conversationUuid);

        if (! $conversation) {
            abort(404, __('Conversation not found'));
        }

        return view($this->masterView, compact('conversation'));
    }
}
