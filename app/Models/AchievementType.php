<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class AchievementType extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'name',
        'is_active',



        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',


    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'achievement_type_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */



    /* ================================================================
     |  Query Scopes
     ================================================================ */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['name'] ?? null,
                fn($q, $name) =>
                $q->where('name', $name)
            );
    }


    /* ================================================================
     |  Query Scopes
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }


    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }



    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);
    //     $this->appends = array_merge(parent::getAppends(), [
    //         //
    //     ]);
    // }
}
