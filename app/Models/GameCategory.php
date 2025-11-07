<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Enums\GameCategoryStatus;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class GameCategory extends BaseModel implements Auditable
{
    use  AuditableTrait;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'icon',
        'is_featured',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',

    ];

    protected $casts = [
        'status' => GameCategoryStatus::class
    ];

    // Scope    


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */




    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', GameCategoryStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', GameCategoryStatus::INACTIVE);
    }


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['name'] ?? null,
                fn($q, $name) =>
                $q->where('name', 'like', "%{$name}%")
            )
            ->when(
                $filters['is_default'] ?? null,
                fn($q, $isDefault) =>
                $q->where('is_default', $isDefault)
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */


    #[SearchUsingPrefix(['id', 'name', 'description', 'meta_title'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'status' => $this->status,
            'is_default' => $this->is_default,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }



    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }



    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
