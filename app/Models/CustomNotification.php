<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\CustomNotificationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class CustomNotification extends BaseModel
{

    protected $fillable = [
        'sort_order',
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'is_announced',
        'type',
        'action',
        'data',
        'additional',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
        'type' => CustomNotificationType::class,
        'is_announced' => 'boolean',
        'additional' => 'array',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function receiver(): MorphTo
    {
        return $this->morphTo();
    }

    // A notification has many statuses (one for each user who received it)
    public function statuses(): HasMany
    {
        return $this->hasMany(CustomNotificationStatus::class, 'notification_id');
    }

    public function deleteds(): HasMany
    {
        return $this->hasMany(DeletedCustomNotification::class, 'notification_id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }

    public function scopeAnnouncementType(Builder $query): Builder
    {
        return $query->where('is_announced', true);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn($q, $type) => $q->where('type', $type));
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->data['title'] ?? '',
            'message' => $this->data['message'] ?? '',
            'type' => $this->type,
        ];
    }

/* ---------------------------------
 | Actor Scopes
 |---------------------------------*/

    /**
     * Filter notifications for a specific receiver or global notifications
     * Global notifications have NULL receiver_id and receiver_type
     */
    public function scopeForReceiver(
        Builder $query,
        int $receiverId,
        string $receiverType
    ): Builder {
        return $query->where(function ($q) use ($receiverId, $receiverType) {
            // Private notification: specific receiver
            $q->where(function ($subQ) use ($receiverId, $receiverType) {
                $subQ->where('receiver_id', $receiverId)
                    ->where('receiver_type', $receiverType);
            })
                // Global notification: NULL receiver (broadcast to all)
                ->orWhere(function ($subQ) {
                    $subQ->whereNull('receiver_id')
                        ->whereNull('receiver_type');
                });
        });
    }

    /**
     * Filter notifications by actor type (admin/user)
     * Includes PUBLIC notifications for all actors
     */
    public function scopeForActorType(Builder $query, string $actorType): Builder
    {
        return $query->where(function ($q) use ($actorType) {
            // Always include PUBLIC notifications
            $q->where('type', CustomNotificationType::PUBLIC);

            // Include type-specific notifications based on actor
            if (str_contains($actorType, 'Admin')) {
                $q->orWhere('type', CustomNotificationType::ADMIN);
            } else {
                $q->orWhere('type', CustomNotificationType::USER);
            }
        });
    }

    /* ---------------------------------
 | Read / Unread Scopes
 |---------------------------------*/

    public function scopeUnreadForActor(
        Builder $query,
        int $actorId,
        string $actorType
    ): Builder {
        return $query->whereDoesntHave('statuses', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType)
                ->whereNotNull('read_at');
        });
    }

    public function scopeReadForActor(
        Builder $query,
        int $actorId,
        string $actorType
    ): Builder {
        return $query->whereHas('statuses', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType)
                ->whereNotNull('read_at');
        });
    }

    /* ---------------------------------
 | Deleted / Not Deleted Scopes
 |---------------------------------*/

    public function scopeDeletedForActor(
        Builder $query,
        int $actorId,
        string $actorType
    ): Builder {
        return $query->whereHas('deleteds', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType);
        });
    }

    public function scopeNotDeletedForActor(
        Builder $query,
        int $actorId,
        string $actorType
    ): Builder {
        return $query->whereDoesntHave('deleteds', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType);
        });
    }

    /* ---------------------------------
 | Dynamic State Filter
 |---------------------------------*/

    public function scopeByState(
        Builder $query,
        string $state,
        int $actorId,
        string $actorType
    ): Builder {
        return match ($state) {
            'read'    => $query->readForActor($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType),

            'unread'  => $query->unreadForActor($actorId, $actorType)
                ->notDeletedForActor($actorId, $actorType),

            'deleted' => $query->deletedForActor($actorId, $actorType),

            default   => $query->notDeletedForActor($actorId, $actorType),
        };
    }
}
