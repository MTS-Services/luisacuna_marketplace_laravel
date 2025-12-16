<?php

namespace App\Services;

use App\Models\CustomNotification;
use App\Models\CustomNotificationStatus;
use App\Models\DeletedCustomNotification;
use App\Events\UserNotificationSent;
use App\Events\AdminNotificationSent;
use App\Enums\CustomNotificationType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(
        protected CustomNotification $notification,
        protected CustomNotificationStatus $status,
        protected DeletedCustomNotification $deleted
    ) {}

    /**
     * Find notification by ID for current actor
     */
    public function find(string $id): ?CustomNotification
    {
        [$actorId, $actorType] = $this->resolveActor();

        return $this->notification
            ->with(['sender', 'receiver'])
            ->where('id', $id)
            ->notDeletedForActor($actorId, $actorType)
            ->first();
    }

    /**
     * Check if unread notifications exist
     */
    public function unreadExists(
        ?CustomNotificationType $type = null,
        ?string $receiverType = null,
        ?int $receiverId = null
    ): bool {
        [$actorId, $actorType] = $this->resolveActor($receiverId, $receiverType);

        $cacheKey = $this->getCacheKey('exists', $actorId, $actorType, $type?->value);

        return $this->notification
            ->query()
            ->when($type, fn($q) => $q->where('type', $type->value)->orWhere('type', CustomNotificationType::PUBLIC->value))
            ->forReceiver($actorId, $actorType)
            ->unreadForActor($actorId, $actorType)
            ->notDeletedForActor($actorId, $actorType)
            ->exists();
        return Cache::remember($cacheKey, 300, function () use ($type, $actorId, $actorType) {
        });
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(
        ?CustomNotificationType $type = null,
        ?string $receiverType = null,
        ?int $receiverId = null
    ): int {
        [$actorId, $actorType] = $this->resolveActor($receiverId, $receiverType);

        $cacheKey = $this->getCacheKey('count', $actorId, $actorType, $type?->value);

        return Cache::remember($cacheKey, 300, function () use ($type, $actorId, $actorType) {
            return $this->notification
                ->query()
                ->when($type, fn($q) => $q->where('type', $type))
                ->forReceiver($actorId, $actorType)
                ->unreadForActor($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType)
                ->count();
        });
    }

    /**
     * Get all notifications with filters
     */
    public function getAll(
        string $state = 'all',
        ?CustomNotificationType $type = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        [$actorId, $actorType] = $this->resolveActor();

        return $this->notification
            ->query()
            ->with(['sender', 'receiver'])
            ->when($type, fn($q) => $q->where('type', $type))
            ->forReceiver($actorId, $actorType)
            ->byState($state, $actorId, $actorType)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get recent notifications
     */
    public function getRecent(int $limit = 10): mixed
    {
        [$actorId, $actorType] = $this->resolveActor();

        return $this->notification
            ->query()
            ->with(['sender'])
            ->forReceiver($actorId, $actorType)
            ->notDeletedForActor($actorId, $actorType)
            ->unreadForActor($actorId, $actorType)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get announcement data with search and filters
     */
    public function getAnnouncementDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $query = $this->notification
            ->query()
            ->announcementType()
            ->filter($filters);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.title')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.message')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.description')) LIKE ?", ["%{$search}%"])
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Create new notification
     */
    public function create(array $data): CustomNotification
    {
        return DB::transaction(function () use ($data) {
            $notificationData = [
                'title' => $data['title'] ?? null,
                'message' => $data['message'] ?? null,
                'description' => $data['description'] ?? null,
                'icon' => $data['icon'] ?? null,
            ];

            $additional = $data['additional'] ?? null;
            if (is_array($additional) && empty($additional)) {
                $additional = null;
            }

            $notification = $this->notification->create([
                'type' => $data['type'],
                'action' => $data['action'] ?? null,
                'sender_id' => $data['sender_id'] ?? null,
                'sender_type' => $data['sender_type'] ?? null,
                'receiver_id' => $data['receiver_id'] ?? null,
                'receiver_type' => $data['receiver_type'] ?? null,
                'is_announced' => $data['is_announced'] ?? false,
                'data' => $notificationData,
                'additional' => $additional,
                'sort_order' => $data['sort_order'] ?? 0,
            ]);

            Log::info('Notification created', ['id' => $notification->id]);

            $this->broadcastNotification($notification);
            $this->clearCache($notification);

            return $notification->fresh();
        });
    }

    /**
     * Update notification
     */
    public function update(string $id, array $data): ?CustomNotification
    {
        return DB::transaction(function () use ($id, $data) {
            $notification = $this->notification->find($id);

            if (!$notification) {
                return null;
            }

            if (isset($data['title']) || isset($data['message']) || isset($data['description']) || isset($data['icon'])) {
                $notificationData = $notification->data ?? [];
                $notificationData['title'] = $data['title'] ?? $notificationData['title'] ?? null;
                $notificationData['message'] = $data['message'] ?? $notificationData['message'] ?? null;
                $notificationData['description'] = $data['description'] ?? $notificationData['description'] ?? null;
                $notificationData['icon'] = $data['icon'] ?? $notificationData['icon'] ?? null;
                $data['data'] = $notificationData;
                unset($data['title'], $data['message'], $data['description'], $data['icon']);
            }

            $notification->update($data);

            $this->clearCache($notification);

            return $notification->fresh();
        });
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(string $notificationId): bool
    {
        [$actorId, $actorType] = $this->resolveActor();

        $notification = $this->find($notificationId);

        if (!$notification) {
            return false;
        }

        return DB::transaction(function () use ($notificationId, $actorId, $actorType, $notification) {
            $this->status->updateOrCreate(
                [
                    'notification_id' => $notificationId,
                    'actor_id' => $actorId,        // Changed from user_id
                    'actor_type' => $actorType,    // Changed from user_type
                ],
                ['read_at' => now()]
            );

            $this->clearActorCache($actorId, $actorType);

            return true;
        });
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(string $notificationId): bool
    {
        [$actorId, $actorType] = $this->resolveActor();

        $updated = $this->status
            ->where('notification_id', $notificationId)
            ->where('actor_id', $actorId)        // Changed from user_id
            ->where('actor_type', $actorType)    // Changed from user_type
            ->update(['read_at' => null]);

        if ($updated) {
            $this->clearActorCache($actorId, $actorType);
        }

        return (bool) $updated;
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(?CustomNotificationType $type = null): int
    {
        [$actorId, $actorType] = $this->resolveActor();

        return DB::transaction(function () use ($actorId, $actorType, $type) {
            $notificationIds = $this->notification
                ->query()
                ->when($type, fn($q) => $q->where('type', $type))
                ->forReceiver($actorId, $actorType)
                ->unreadForActor($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType)
                ->pluck('id');

            if ($notificationIds->isEmpty()) {
                return 0;
            }

            $now = now();
            foreach ($notificationIds as $notificationId) {
                $this->status->updateOrCreate(
                    [
                        'notification_id' => $notificationId,
                        'actor_id' => $actorId,        // Changed from user_id
                        'actor_type' => $actorType,    // Changed from user_type
                    ],
                    ['read_at' => $now]
                );
            }

            $this->clearActorCache($actorId, $actorType);

            return $notificationIds->count();
        });
    }

    /**
     * Soft delete notification for actor
     */
    public function delete(string $notificationId): bool
    {
        [$actorId, $actorType] = $this->resolveActor();

        $notification = $this->find($notificationId);

        if (!$notification) {
            return false;
        }

        $exists = $this->deleted
            ->where('notification_id', $notificationId)
            ->where('actor_id', $actorId)        // Changed from user_id
            ->where('actor_type', $actorType)    // Changed from user_type
            ->exists();

        if ($exists) {
            return true;
        }

        $created = $this->deleted->create([
            'notification_id' => $notificationId,
            'actor_id' => $actorId,        // Changed from user_id
            'actor_type' => $actorType,    // Changed from user_type
        ]);

        if ($created) {
            $this->clearActorCache($actorId, $actorType);
        }

        return (bool) $created;
    }

    /**
     * Delete multiple notifications
     */
    public function deleteMany(array $notificationIds): int
    {
        [$actorId, $actorType] = $this->resolveActor();

        return DB::transaction(function () use ($notificationIds, $actorId, $actorType) {
            $records = collect($notificationIds)->map(fn($id) => [
                'notification_id' => $id,
                'actor_id' => $actorId,        // Changed from user_id
                'actor_type' => $actorType,    // Changed from user_type
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            $this->deleted->insert($records);
            $this->clearActorCache($actorId, $actorType);

            return count($records);
        });
    }

    /**
     * Delete all notifications for actor
     */
    public function deleteAll(?CustomNotificationType $type = null): int
    {
        [$actorId, $actorType] = $this->resolveActor();

        return DB::transaction(function () use ($actorId, $actorType, $type) {
            $notificationIds = $this->notification
                ->query()
                ->when($type, fn($q) => $q->where('type', $type))
                ->forReceiver($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType)
                ->pluck('id');

            if ($notificationIds->isEmpty()) {
                return 0;
            }

            $records = $notificationIds->map(fn($id) => [
                'notification_id' => $id,
                'actor_id' => $actorId,        // Changed from user_id
                'actor_type' => $actorType,    // Changed from user_type
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            $this->deleted->insert($records);
            $this->clearActorCache($actorId, $actorType);

            return count($records);
        });
    }

    /**
     * Restore deleted notification
     */
    public function restore(string $notificationId): bool
    {
        [$actorId, $actorType] = $this->resolveActor();

        $deleted = $this->deleted
            ->where('notification_id', $notificationId)
            ->where('actor_id', $actorId)        // Changed from user_id
            ->where('actor_type', $actorType)    // Changed from user_type
            ->delete();

        if ($deleted) {
            $this->clearActorCache($actorId, $actorType);
        }

        return (bool) $deleted;
    }

    /**
     * Force delete notification permanently (admin only)
     */
    public function forceDelete(string $notificationId): bool
    {
        $notification = $this->notification->find($notificationId);

        if (!$notification) {
            return false;
        }

        return DB::transaction(function () use ($notification) {
            $notification->statuses()->delete();
            $notification->deleteds()->delete();

            $this->clearCache($notification);

            return $notification->delete();
        });
    }

    /**
     * Get notification statistics
     */
    public function getStats(?CustomNotificationType $type = null): array
    {
        [$actorId, $actorType] = $this->resolveActor();

        $cacheKey = $this->getCacheKey('stats', $actorId, $actorType, $type?->value);

        return Cache::remember($cacheKey, 600, function () use ($type, $actorId, $actorType) {
            $query = $this->notification
                ->query()
                ->when($type, fn($q) => $q->where('type', $type))
                ->forReceiver($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType);

            $total = $query->count();
            $unread = (clone $query)->unreadForActor($actorId, $actorType)->count();
            $read = (clone $query)->readForActor($actorId, $actorType)->count();

            return compact('total', 'unread', 'read');
        });
    }

    /**
     * Broadcast notification based on type
     */
    protected function broadcastNotification(CustomNotification $notification): void
    {
        match ($notification->type) {
            CustomNotificationType::USER => broadcast(new UserNotificationSent($notification)),
            CustomNotificationType::ADMIN => broadcast(new AdminNotificationSent($notification)),
            CustomNotificationType::PUBLIC => [
                broadcast(new UserNotificationSent($notification)),
                broadcast(new AdminNotificationSent($notification))
            ],
            default => null,
        };

        Log::info('Notification broadcasted', [
            'id' => $notification->id,
            'type' => $notification->type->value
        ]);
    }

    /**
     * Resolve current actor (user or admin)
     */
    protected function resolveActor(?int $id = null, ?string $type = null): array
    {
        if ($id && $type) {
            return [$id, $type];
        }

        if ($user = user()) {
            return [$user->id, get_class($user)];
        }

        if (function_exists('admin') && $admin = admin()) {
            return [$admin->id, get_class($admin)];
        }

        throw new \RuntimeException('No authenticated actor found');
    }

    /**
     * Generate cache key
     */
    protected function getCacheKey(string $prefix, int $actorId, string $actorType, ?string $suffix = null): string
    {
        $key = "notifications:{$prefix}:{$actorType}:{$actorId}";
        return $suffix ? "{$key}:{$suffix}" : "{$key}:all";
    }

    /**
     * Clear cache for specific actor
     */
    protected function clearActorCache(int $actorId, string $actorType): void
    {
        $patterns = ['exists', 'count', 'stats'];

        foreach ($patterns as $pattern) {
            Cache::forget($this->getCacheKey($pattern, $actorId, $actorType));

            foreach (CustomNotificationType::cases() as $type) {
                Cache::forget($this->getCacheKey($pattern, $actorId, $actorType, $type->value));
            }
        }
    }

    /**
     * Clear all related cache for notification
     */
    protected function clearCache(CustomNotification $notification): void
    {
        // Only clear receiver cache if receiver exists
        if ($notification->receiver_id && $notification->receiver_type) {
            $this->clearActorCache($notification->receiver_id, $notification->receiver_type);
        }

        // Clear sender cache if sender exists
        if ($notification->sender_id && $notification->sender_type) {
            $this->clearActorCache($notification->sender_id, $notification->sender_type);
        }
    }
}
