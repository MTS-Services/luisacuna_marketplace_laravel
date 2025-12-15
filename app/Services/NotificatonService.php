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
    public function __construct(protected CustomNotification $model) {}

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

    public function getAnnouncementDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            return CustomNotification::search($search)
                ->announcementType()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->query()
            ->announcementType()
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



    public function createData(array $data): CustomNotification
    {
        $notificationData = [
            'title' => $data['title'] ?? null,
            'message' => $data['message'] ?? null,
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? null,
        ];

        // Don't include additional in data JSON since it has its own column
        // Remove this block:
        // if (isset($data['additional']) && !empty($data['additional'])) {
        //     $notificationData['additional'] = $data['additional'];
        // }

        $notification = $this->model->create([
            'type' => $data['type'],
            'action' => $data['action'] ?? null,
            'sender_id' => $data['sender_id'] ?? null,
            'sender_type' => $data['sender_type'] ?? null,
            'receiver_id' => $data['receiver_id'] ?? null,
            'receiver_type' => $data['receiver_type'] ?? null,
            'is_announced' => $data['is_announced'] ?? false,
            'data' => $notificationData,
            'additional' => $data['additional'] ?? null,
        ]);
        $this->broadcastNotification($notification);
        return $notification;
    }

    protected function broadcastNotification(CustomNotification $notification): void
    {
        switch ($notification->type) {
            case CustomNotificationType::USER->value:
                broadcast(new UserNotificationSent($notification));
                break;

            case CustomNotificationType::ADMIN->value:
                broadcast(new AdminNotificationSent($notification));
                break;

            case CustomNotificationType::PUBLIC->value:
                broadcast(new UserNotificationSent($notification));
                broadcast(new AdminNotificationSent($notification));
                break;
        }
    }
}
