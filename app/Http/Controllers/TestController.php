<?php

namespace App\Http\Controllers;

use App\Enums\CustomNotificationType;
use App\Events\AdminNotificationSent;
use Illuminate\Http\Request;
use App\Events\UserNotificationSent;
use App\Models\Admin;
use App\Models\CustomNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            // Get input values from the request
            $userId = $request->input('user_id');
            $sendTo = $request->input('send_to', 'users');
            $message = $request->input('message', 'Hello from Laravel!');
            $description = $request->input('description', 'This is a notification.');

            $receiverId = null;
            $receiverType = null;
            $type = null;

            switch ($sendTo) {
                case 'users':
                    $type = CustomNotificationType::USER->value;
                    $receiverType = User::class;
                    if ($userId) {
                        $user = User::find($userId);
                        if (!$user) {
                            return redirect()->back()->with('error', 'User not found.');
                        }
                        $receiverId = $user->id;
                    }
                    break;

                case 'admins':
                    $type = CustomNotificationType::ADMIN->value;
                    $receiverType = Admin::class;
                    if ($userId) {
                        $admin = Admin::find($userId);
                        if (!$admin) {
                            return redirect()->back()->with('error', 'Admin not found.');
                        }
                        $receiverId = $admin->id;
                    }
                    break;
                default:
                    $type = CustomNotificationType::PUBLIC->value;
                    $receiverType = null;
                    $receiverId = null;
                    break;
            }

            $title = $request->input('title', ($receiverId ? 'Private Notification' : 'Public Notification'));

            // Create the notification record in the database
            $notification = CustomNotification::create([
                'type' => $type,
                'receiver_id' => $receiverId,
                'receiver_type' => $receiverType,
                'data' => [
                    'title' => $title,
                    'icon' => 'bell-ring',
                    'message' => $message,
                    'description' => $description,
                    'additional_data' => [
                        'userId' => $userId,
                        'sendTo' => $sendTo,
                    ],
                ],
                'action' => route('home')
            ]);

            if ($sendTo === 'users') {
                broadcast(new UserNotificationSent($notification));
            }
            if ($sendTo === 'admins') {
                broadcast(new AdminNotificationSent($notification));
            }
            if ($sendTo === 'public') {
                Log::info('Broadcasting public notification');
                broadcast(new UserNotificationSent($notification));
                broadcast(new AdminNotificationSent($notification));
            }
            return redirect()->back()->with('success', 'Notification sent successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }
}
