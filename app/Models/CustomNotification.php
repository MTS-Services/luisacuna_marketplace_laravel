<?php

namespace App\Models;

use App\Enums\CustomNotificationType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'data'         => 'array',
        'additional'   => 'array',
        'created_at'   => 'datetime',
        'type'         => CustomNotificationType::class,
        'is_announced' => 'boolean',
    ];

    /* ═══════════════════════════════════════
     |  Relationships
     ═══════════════════════════════════════ */

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function receiver(): MorphTo
    {
        return $this->morphTo();
    }

    /** One status row per actor who received this notification */
    public function statuses(): HasMany
    {
        return $this->hasMany(CustomNotificationStatus::class, 'notification_id');
    }

    /** Soft-delete records per actor */
    public function deleteds(): HasMany
    {
        return $this->hasMany(DeletedCustomNotification::class, 'notification_id');
    }

    /* ═══════════════════════════════════════
     |  Boot / Constructor
     ═══════════════════════════════════════ */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), []);
    }

    /* ═══════════════════════════════════════
     |  Scout
     ═══════════════════════════════════════ */

    public function toSearchableArray(): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->data['title']   ?? '',
            'message' => $this->data['message']  ?? '',
            'type'    => $this->type,
        ];
    }

    /* ═══════════════════════════════════════
     |  General Scopes
     ═══════════════════════════════════════ */

    public function scopeAnnouncementType(Builder $query): Builder
    {
        return $query->where('is_announced', true);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['status'] ?? null,
            fn ($q, $type) => $q->where('type', $type)
        );
    }

    /* ═══════════════════════════════════════
     |  Receiver Scopes
     ═══════════════════════════════════════ */

    /**
     * Notifications sent to this specific actor OR broadcast to everyone
     * (receiver_id / receiver_type both NULL).
     *
     * Fetching rules:
     *  1. type = public  → all actors
     *  2. type = admin   + receiver IS NULL → all admins (broadcast)
     *  3. type = admin   + receiver_id = actor id + receiver_type = Admin class
     */
    public function scopeForReceiver(Builder $query, int $receiverId, string $receiverType): Builder
    {
        return $query->where(function ($q) use ($receiverId, $receiverType) {
            // Targeted notification for this specific actor
            $q->where(function ($sub) use ($receiverId, $receiverType) {
                $sub->where('receiver_id', $receiverId)
                    ->where('receiver_type', $receiverType);
            })
            // Broadcast notification (no specific receiver)
            ->orWhere(function ($sub) {
                $sub->whereNull('receiver_id')
                    ->whereNull('receiver_type');
            });
        });
    }

    /**
     * Include PUBLIC notifications for all actors;
     * additionally include ADMIN for admin actors or USER for user actors.
     */
    public function scopeForActorType(Builder $query, string $actorType): Builder
    {
        return $query->where(function ($q) use ($actorType) {
            $q->where('type', CustomNotificationType::PUBLIC);

            if (str_contains($actorType, 'Admin')) {
                $q->orWhere('type', CustomNotificationType::ADMIN);
            } else {
                $q->orWhere('type', CustomNotificationType::USER);
            }
        });
    }

    /* ═══════════════════════════════════════
     |  Read / Unread Scopes
     ═══════════════════════════════════════ */

    public function scopeUnreadForActor(Builder $query, int $actorId, string $actorType): Builder
    {
        return $query->whereDoesntHave('statuses', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType)
                ->whereNotNull('read_at');
        });
    }

    public function scopeReadForActor(Builder $query, int $actorId, string $actorType): Builder
    {
        return $query->whereHas('statuses', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)
                ->where('actor_type', $actorType)
                ->whereNotNull('read_at');
        });
    }

    /* ═══════════════════════════════════════
     |  Deleted / Not-Deleted Scopes
     ═══════════════════════════════════════ */

    public function scopeDeletedForActor(Builder $query, int $actorId, string $actorType): Builder
    {
        return $query->whereHas('deleteds', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)->where('actor_type', $actorType);
        });
    }

    public function scopeNotDeletedForActor(Builder $query, int $actorId, string $actorType): Builder
    {
        return $query->whereDoesntHave('deleteds', function ($q) use ($actorId, $actorType) {
            $q->where('actor_id', $actorId)->where('actor_type', $actorType);
        });
    }

    /* ═══════════════════════════════════════
     |  Composite State Scope
     ═══════════════════════════════════════
     |  Single authority for the notDeleted / deleted constraint.
     |  Callers (e.g. getAll) must NOT also call notDeletedForActor.
     ═══════════════════════════════════════ */

    public function scopeByState(Builder $query, string $state, int $actorId, string $actorType): Builder
    {
        return match ($state) {
            'read'    => $query->readForActor($actorId, $actorType)
                               ->notDeletedForActor($actorId, $actorType),

            'unread'  => $query->unreadForActor($actorId, $actorType)
                               ->notDeletedForActor($actorId, $actorType),

            'deleted' => $query->deletedForActor($actorId, $actorType),

            default   => $query->notDeletedForActor($actorId, $actorType),
        };
    }

    /* ═══════════════════════════════════════
     |  Helpers
     ═══════════════════════════════════════ */

    /**
     * Check whether this notification has been read by the given actor.
     *
     * @param string $actorId   Encrypted actor ID (as used in blades via encrypt())
     * @param string $actorType Fully-qualified actor class name
     *
     * Priority: uses the already-loaded `statuses` relation collection when available
     * to avoid an extra DB round-trip per notification card and to stay in sync with
     * the data used for all other queries (stats, filter counts, etc.).
     * Falls back to a fresh DB query when the relation is not loaded.
     */
    public function isRead(string $actorId, string $actorType): bool
    {
        $decryptedId = decrypt($actorId);

        // Use the eager-loaded collection — same data as the list/stats queries.
        // This prevents the "stats say read but card shows unread" inconsistency
        // caused by a fresh DB query racing against the just-committed write.
        if ($this->relationLoaded('statuses')) {
            return $this->statuses
                ->where('actor_id', $decryptedId)
                ->where('actor_type', $actorType)
                ->whereNotNull('read_at')
                ->isNotEmpty();
        }

        // Fallback for contexts where statuses are not eager-loaded
        return (bool) $this->statuses()
            ->where('actor_id', $decryptedId)
            ->where('actor_type', $actorType)
            ->whereNotNull('read_at')
            ->exists();
    }
}