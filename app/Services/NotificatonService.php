<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Models\CustomNotification;
use App\Events\UserNotificationSent;
use App\Events\AdminNotificationSent;
use App\Enums\CustomNotificationType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class NotificatonService
{
    public function __construct(protected CustomNotification $model) {}

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        // Check if search is provided and Scout is configured
        if ($search && config('scout.driver')) {
            return CustomNotification::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Fallback to regular query if no search or Scout not configured
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    public function getAnnouncementDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $baseQuery = $this->model->query()
            ->announcementType()
            ->filter($filters);

        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                // Use indexed virtual columns for lightning-fast search
                $q->where('title_searchable', 'like', "%{$search}%")
                    ->orWhere('message_searchable', 'like', "%{$search}%")
                    ->orWhere('description_searchable', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        return $baseQuery
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
        // Clean up additional data - store null if empty
        $additional = $data['additional'] ?? null;
        if (is_array($additional) && empty($additional)) {
            $additional = null;
        }

        $notification = $this->model->create([
            'type' => $data['type'],
            'action' => $data['action'] ?? null,
            'sender_id' => $data['sender_id'] ?? null,
            'sender_type' => $data['sender_type'] ?? null,
            'receiver_id' => $data['receiver_id'] ?? null,
            'receiver_type' => $data['receiver_type'] ?? null,
            'is_announced' => $data['is_announced'] ?? false,
            'data' => $notificationData,
            'additional' => $additional,
        ]);
        Log::info('Notification created: ' . $notification->id);
        $this->broadcastNotification($notification);
        return $notification;
    }

    protected function broadcastNotification(CustomNotification $notification): void
    {
        switch ($notification->type) {
            case CustomNotificationType::USER:
                Log::info('Broadcasting user notification' . $notification->id);
                broadcast(new UserNotificationSent($notification));
                return;

            case CustomNotificationType::ADMIN:
                Log::info('Broadcasting admin notification' . $notification->id);
                broadcast(new AdminNotificationSent($notification));
                return;

            case CustomNotificationType::PUBLIC:
                Log::info('Broadcasting public notification' . $notification->id);
                broadcast(new UserNotificationSent($notification));
                broadcast(new AdminNotificationSent($notification));
                return;
        }
    }
}
