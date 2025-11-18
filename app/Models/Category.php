<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Category extends BaseModel implements Auditable
{
    use  AuditableTrait;


    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'icon',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',

    ];

    protected $hidden = [
        'id',    
      
    ];
    protected $casts = [
        'status' => CategoryStatus::class
    ];

    // Scope    


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

     
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'category_id', 'id');
    }
    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */




    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::INACTIVE);
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
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */


    #[SearchUsingPrefix(['id', 'name', 'meta_title'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'meta_title' => $this->meta_title,
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
