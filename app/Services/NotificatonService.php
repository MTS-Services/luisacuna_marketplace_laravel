<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Models\CustomNotification;
use App\Events\UserNotificationSent;
use App\Events\AdminNotificationSent;
use App\Enums\CustomNotificationType;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificatonService
{
    public function __construct(protected CustomNotification $model)
    {
        //
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            return CustomNotification::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->query()
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }


    public function findData($column_value, string $column_name = 'id', bool $trashed = false): ?CustomNotification
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }



    public function createData(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Notification send o store korar main method
     */
    public function sendNotification(array $data): CustomNotification
    {
        // Notification data prepare
        $notificationData = $this->prepareNotificationData($data);

        // Database e store
        $notification = $this->createData($notificationData);

        // Broadcast event fire
        $this->broadcastNotification($notification, $data['send_to']);

        return $notification;
    }

    /**
     * Notification data prepare
     */
    protected function prepareNotificationData(array $data): array
    {
        $receiverId = null;
        $receiverType = null;
        $type = null;

        switch ($data['send_to']) {
            case 'users':
                $type = CustomNotificationType::USER->value;
                $receiverType = User::class;
                if (!empty($data['user_id'])) {
                    $user = User::findOrFail($data['user_id']);
                    $receiverId = $user->id;
                }
                break;

            case 'admins':
                $type = CustomNotificationType::ADMIN->value;
                $receiverType = Admin::class;
                if (!empty($data['user_id'])) {
                    $admin = Admin::findOrFail($data['user_id']);
                    $receiverId = $admin->id;
                }
                break;

            default: // public
                $type = CustomNotificationType::PUBLIC->value;
                $receiverType = null;
                $receiverId = null;
                break;
        }

        $title = $data['title'] ?? ($receiverId ? 'Private Notification' : 'Public Notification');

        return [
            'type' => $type,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
            'data' => [
                'title' => $title,
                'icon' => $data['icon'] ?? 'bell-ring',
                'message' => $data['message'],
                'description' => $data['description'] ?? null,
                'additional_data' => [
                    'userId' => $data['user_id'] ?? null,
                    'sendTo' => $data['send_to'],
                ],
            ],
            'action' => $data['action'] ?? route('home')
        ];
    }

    /**
     * Broadcast notification event
     */
    protected function broadcastNotification(CustomNotification $notification, string $sendTo): void
    {
        switch ($sendTo) {
            case 'users':
                broadcast(new UserNotificationSent($notification));
                break;

            case 'admins':
                broadcast(new AdminNotificationSent($notification));
                break;

            case 'public':
                broadcast(new UserNotificationSent($notification));
                broadcast(new AdminNotificationSent($notification));
                break;
        }
    }
}
