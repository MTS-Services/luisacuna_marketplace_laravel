<?php

namespace App\Services;

use App\Enums\CustomNotificationType;
use App\Events\AdminNotificationSent;
use App\Events\UserNotificationSent;
use App\Models\Admin;
use App\Models\CustomNotification;
use App\Models\CustomNotificationStatus;
use App\Models\DeletedCustomNotification;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(
        protected CustomNotification $notification,
        protected CustomNotificationStatus $status,
        protected DeletedCustomNotification $deleted
    ) {}

    /**
     * Find notification by ID (with all relations)
     */
    public function find(string $id): ?CustomNotification
    {
        return $this->notification
            ->with(['sender', 'receiver', 'statuses', 'deleteds'])
            ->find($id);
    }

    /**
     * Get unread count for the resolved actor
     */
    public function getUnreadCount(
        ?CustomNotificationType $type = null,
        ?string $receiverType = null,
        ?int $receiverId = null
    ): int {
        [$actorId, $actorType] = $this->resolveActor($receiverId, $receiverType);

        return $this->notification
            ->query()
            ->forReceiver($actorId, $actorType)
            ->forActorType($actorType)
            ->when($type, fn($q) => $q->where('type', $type))
            ->unreadForActor($actorId, $actorType)
            ->notDeletedForActor($actorId, $actorType)
            ->count();
    }

    /**
     * Check if unread notifications exist for the resolved actor
     */
    public function unreadExists(
        ?CustomNotificationType $type = null,
        ?string $receiverType = null,
        ?int $receiverId = null
    ): bool {
        [$actorId, $actorType] = $this->resolveActor($receiverId, $receiverType);

        return $this->notification
            ->query()
            ->forReceiver($actorId, $actorType)
            ->forActorType($actorType)
            ->when($type, fn($q) => $q->where('type', $type))
            ->unreadForActor($actorId, $actorType)
            ->notDeletedForActor($actorId, $actorType)
            ->exists();
    }

    /**
     * Get paginated notifications with state filter (all / read / unread / deleted)
     */
    public function getAll(
        string $state = 'all',
        ?CustomNotificationType $type = null,
        int $perPage = 20,
        ?string $actorType = null
    ): LengthAwarePaginator {
        [$actorId, $actorType] = $this->resolveActor(null, $actorType);

        return $this->notification
            ->query()
            ->with(['sender', 'receiver', 'statuses', 'deleteds'])
            ->forReceiver($actorId, $actorType)
            ->forActorType($actorType)
            ->when($type, fn($q) => $q->where('type', $type))
            ->byState($state, $actorId, $actorType)   // byState owns notDeleted / deleted scoping
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get recent notifications (used by Sidebar)
     */
    public function getRecent(int $limit = 10, ?string $actorType = null): mixed
    {
        [$actorId, $actorType] = $this->resolveActor(null, $actorType);

        return $this->notification
            ->query()
            ->with(['sender', 'receiver', 'statuses', 'deleteds'])
            ->forReceiver($actorId, $actorType)
            ->forActorType($actorType)
            ->notDeletedForActor($actorId, $actorType)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get announcement data with search and filters (for announcement management page)
     */
    public function getAnnouncementDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        return $this->notification
            ->query()
            ->announcementType()
            ->filter($filters)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.title')) LIKE ?", ["%{$search}%"])
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.message')) LIKE ?", ["%{$search}%"])
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.description')) LIKE ?", ["%{$search}%"])
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('action', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Create a new notification and broadcast it
     */
    public function create(array $data): CustomNotification
    {
        return DB::transaction(function () use ($data) {
            $additional = $data['additional'] ?? null;
            if (is_array($additional) && empty($additional)) {
                $additional = null;
            }

            $notification = $this->notification->create([
                'type'          => $data['type'],
                'action'        => $data['action'] ?? null,
                'sender_id'     => $data['sender_id'] ?? null,
                'sender_type'   => $data['sender_type'] ?? null,
                'receiver_id'   => $data['receiver_id'] ?? null,
                'receiver_type' => $data['receiver_type'] ?? null,
                'is_announced'  => $data['is_announced'] ?? false,
                'sort_order'    => $data['sort_order'] ?? 0,
                'additional'    => $additional,
                'data'          => [
                    'title'       => $data['title'] ?? null,
                    'message'     => $data['message'] ?? null,
                    'description' => $data['description'] ?? null,
                    'icon'        => $data['icon'] ?? null,
                ],
            ]);

            Log::info('Notification created', ['id' => $notification->id]);

            $this->broadcastNotification($notification);

            return $notification->fresh();
        });
    }

    /**
     * Update an existing notification
     */
    public function update(string $id, array $data): ?CustomNotification
    {
        return DB::transaction(function () use ($id, $data) {
            $notification = $this->notification->find($id);

            if (! $notification) {
                return null;
            }

            // Merge data-column fields if any were supplied
            if (array_intersect_key($data, array_flip(['title', 'message', 'description', 'icon']))) {
                $existing = $notification->data ?? [];
                $data['data'] = [
                    'title'       => $data['title']       ?? $existing['title']       ?? null,
                    'message'     => $data['message']     ?? $existing['message']     ?? null,
                    'description' => $data['description'] ?? $existing['description'] ?? null,
                    'icon'        => $data['icon']        ?? $existing['icon']        ?? null,
                ];
                unset($data['title'], $data['message'], $data['description'], $data['icon']);
            }

            $notification->update($data);

            return $notification->fresh();
        });
    }

    /**
     * Mark a single notification as read for the current actor
     */
    public function markAsRead(string $notificationId, ?string $actorType = null): bool
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        if (! $this->find($notificationId)) {
            return false;
        }

        $this->status->updateOrCreate(
            [
                'notification_id' => $notificationId,
                'actor_id'        => $actorId,
                'actor_type'      => $actorType,
            ],
            ['read_at' => now()]
        );

        return true;
    }

    /**
     * Mark a single notification as unread for the current actor
     */
    public function markAsUnread(string $notificationId, ?string $actorType = null): bool
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        return (bool) $this->status
            ->where('notification_id', $notificationId)
            ->where('actor_id', $actorId)
            ->where('actor_type', $actorType)
            ->update(['read_at' => null]);
    }

    /**
     * Mark all unread notifications as read for the current actor
     * Uses upsert for a single efficient DB round-trip
     */
    public function markAllAsRead(?CustomNotificationType $type = null, ?string $actorType = null): int
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        return DB::transaction(function () use ($actorId, $actorType, $type) {
            $notificationIds = $this->notification
                ->query()
                ->forReceiver($actorId, $actorType)
                ->forActorType($actorType)
                ->when($type, fn($q) => $q->where('type', $type))
                ->unreadForActor($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType)
                ->pluck('id');

            if ($notificationIds->isEmpty()) {
                return 0;
            }

            $now = now();

            $this->status->upsert(
                $notificationIds->map(fn($id) => [
                    'notification_id' => $id,
                    'actor_id'        => $actorId,
                    'actor_type'      => $actorType,
                    'read_at'         => $now,
                ])->toArray(),
                ['notification_id', 'actor_id', 'actor_type'],
                ['read_at']
            );

            return $notificationIds->count();
        });
    }

    /**
     * Soft-delete a notification for the current actor
     */
    public function delete(string $notificationId, ?string $actorType = null): bool
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        if (! $this->find($notificationId)) {
            return false;
        }

        // insertOrIgnore handles the case where the record already exists
        $this->deleted->insertOrIgnore([
            'notification_id' => $notificationId,
            'actor_id'        => $actorId,
            'actor_type'      => $actorType,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return true;
    }

    /**
     * Soft-delete multiple notifications for the current actor
     */
    public function deleteMany(array $notificationIds, ?string $actorType = null): int
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        $now = now();

        $records = collect($notificationIds)->map(fn($id) => [
            'notification_id' => $id,
            'actor_id'        => $actorId,
            'actor_type'      => $actorType,
            'created_at'      => $now,
            'updated_at'      => $now,
        ])->toArray();

        // insertOrIgnore skips duplicates gracefully
        $this->deleted->insertOrIgnore($records);

        return count($records);
    }

    /**
     * Soft-delete all visible notifications for the current actor
     */
    public function deleteAll(?CustomNotificationType $type = null, ?string $actorType = null): int
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        return DB::transaction(function () use ($actorId, $actorType, $type) {
            $notificationIds = $this->notification
                ->query()
                ->forReceiver($actorId, $actorType)
                ->forActorType($actorType)
                ->when($type, fn($q) => $q->where('type', $type))
                ->notDeletedForActor($actorId, $actorType)
                ->pluck('id');

            if ($notificationIds->isEmpty()) {
                return 0;
            }

            $now = now();

            $this->deleted->insertOrIgnore(
                $notificationIds->map(fn($id) => [
                    'notification_id' => $id,
                    'actor_id'        => $actorId,
                    'actor_type'      => $actorType,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ])->toArray()
            );

            return $notificationIds->count();
        });
    }

    /**
     * Restore a soft-deleted notification for the current actor
     */
    public function restore(string $notificationId, ?string $actorType = null): bool
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        return (bool) $this->deleted
            ->where('notification_id', $notificationId)
            ->where('actor_id', $actorId)
            ->where('actor_type', $actorType)
            ->delete();
    }

    /**
     * Permanently delete a notification and all its statuses (admin-only operation)
     */
    public function forceDelete(string $notificationId): bool
    {
        $notification = $this->notification->find($notificationId);

        if (! $notification) {
            return false;
        }

        return DB::transaction(function () use ($notification) {
            $notification->statuses()->delete();
            $notification->deleteds()->delete();

            return $notification->delete();
        });
    }

    /**
     * Get read / unread / total stats for the current actor
     */
    public function getStats(?CustomNotificationType $type = null, ?string $actorType = null): array
    {
        [$actorId, $actorType] = $this->resolveActor(type: $actorType);

        $base = $this->notification
            ->query()
            ->forReceiver($actorId, $actorType)
            ->forActorType($actorType)
            ->when($type, fn($q) => $q->where('type', $type))
            ->notDeletedForActor($actorId, $actorType);

        $total  = $base->count();
        $unread = (clone $base)->unreadForActor($actorId, $actorType)->count();
        $read   = (clone $base)->readForActor($actorId, $actorType)->count();

        return compact('total', 'unread', 'read');
    }

    // ─────────────────────────────────────────────────────────────
    //  Internals
    // ─────────────────────────────────────────────────────────────

    /**
     * Broadcast the notification to the appropriate channel(s)
     */
    protected function broadcastNotification(CustomNotification $notification): void
    {
        match ($notification->type) {
            CustomNotificationType::USER   => broadcast(new UserNotificationSent($notification)),
            CustomNotificationType::ADMIN  => broadcast(new AdminNotificationSent($notification)),
            CustomNotificationType::PUBLIC => [
                broadcast(new UserNotificationSent($notification)),
                broadcast(new AdminNotificationSent($notification)),
            ],
            default => null,
        };

        Log::info('Notification broadcasted', [
            'id'   => $notification->id,
            'type' => $notification->type->value,
        ]);
    }

    /**
     * Resolve the currently authenticated actor [id, fully-qualified class name].
     *
     * Priority:
     *   1. Explicit $id + $type arguments
     *   2. $type === 'admin' shorthand
     *   3. Admin routes  → admin()
     *   4. Everything else → user()
     *
     * @throws \RuntimeException when no actor can be resolved
     */
    protected function resolveActor(?int $id = null, ?string $type = null): array
    {
        // Explicit override
        if ($id && $type) {
            return [$id, $type];
        }

        // Shorthand for "force admin" (used by getRecent with onlyAdmin=true)
        if ($type === 'admin') {
            return [admin()->id, Admin::class];
        }

        // Shorthand for "force user" (used by getRecent with onlyUser=true)
        if ($type === 'user') {
            return [user()->id, User::class];
        }

        // Admin routes
        if (request()->routeIs('admin.*')) {
            if ($admin = admin()) {
                return [$admin->id, get_class($admin)];
            }
        }

        // User routes
        if ($user = user()) {
            return [$user->id, get_class($user)];
        }

        throw new \RuntimeException('No authenticated actor found');
    }
}
