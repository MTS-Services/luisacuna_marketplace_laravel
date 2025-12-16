<?php

namespace App\Http\Controllers\Backend\Admin\ChatManagement;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected string $masterView = 'backend.admin.pages.chat-management.chat';

    public function index()
    {
        return view($this->masterView);
    }

    public function chat(string $id)
    {
        $data = Message::find($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
