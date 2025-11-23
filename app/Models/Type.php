<?php

namespace App\Models;

use App\Enums\TypeStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Type extends AuditBaseModel implements Auditable
{
    use   AuditableTrait , Searchable;

    protected $fillable = [
        'sort_order',
        'name',
        'status',
        'icon',


        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    protected $hidden = [
        //

        'id',
    ];

    protected $casts = [
        'status' => TypeStatus::class,
        'restored_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function games()
    {
        return $this->belongsToMany(
            Game::class,
            'game_types',
            'type_id',
            'game_id'
        );
    }

     /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', TypeStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', TypeStatus::INACTIVE);
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

    #[SearchUsingPrefix(['id', 'name',])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }



}
