<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\CustomNotificationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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
}
