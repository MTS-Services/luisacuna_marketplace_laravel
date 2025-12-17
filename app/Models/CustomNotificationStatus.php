<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class CustomNotificationStatus extends BaseModel
{
    protected $fillable = [
        'actor_id',
        'actor_type',
        'notification_id',
        'read_at',
    ];
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function actor(): MorphTo
    {
        return $this->morphTo();
    }

    // The notification this status belongs to
    public function notification(): BelongsTo
    {
        return $this->belongsTo(CustomNotification::class, 'notification_id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'read_at_formated',
        ]);
    }

    public function scopeForCurrentUser(Builder $query): Builder
    {
        return $query->where('actor_id', user()->id)
            ->where('actor_type', User::class);
    }
    public function scopeForCurrentAdmin(Builder $query): Builder
    {
        return $query->where('actor_id', admin()->id)
            ->where('actor_type', Admin::class);
    }

    public function getReadAtFormattedAttribute()
    {
        return $this->read_at ? timeFormat($this->read_at) : 'N/A';
    }
}
