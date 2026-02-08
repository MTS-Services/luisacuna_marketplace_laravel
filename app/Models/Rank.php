<?php

namespace App\Models;

use App\Enums\RankStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Spatie\Searchable\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rank extends AuditBaseModel implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'minimum_points',
        'maximum_points',
        'icon',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',


        //here AuditColumns
    ];

    protected $hidden = [
        //
        'id',

    ];

    protected $casts = [
        //
        'status' => RankStatus::class,
        'restored_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'rank_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_ranks')
            ->withPivot('activated_at', 'rank_id');
    }

    // public function AchievementProgress()
    // {
    //     return $this->hasMany(UserAchievementProgress::class, 'rank_id', 'id');
    // }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', RankStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', RankStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name', 'minimum_points', 'maximum_points'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
            'minimum_points' => $this->minimum_points,
            'maximum_points' => $this->maximum_points,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of ATTRIBUTES
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
