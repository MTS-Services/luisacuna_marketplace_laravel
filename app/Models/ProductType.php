<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use App\Enums\ProductTypeStatus;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;


class ProductType extends AuditBaseModel implements Auditable
{
    use AuditableTrait, Searchable;

    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'description',
        'icon',
        'requires_delivery_time',
        'requires_server_info',
        'requires_character_info',
        'max_delivery_time_hours',
        'commission_rate',
        'status',


        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',

        'creater_type',
        'updater_type',
        'deleter_type',
        'restorer_type',


        'restored_at',
        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'status' => ProductTypeStatus::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProductTypeStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', ProductTypeStatus::INACTIVE);
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
                $filters['slug'] ?? null,
                fn($q, $slug) =>
                $q->where('slug', 'like', "%{$slug}%")
            );
    }


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */




    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name', 'slug', 'description'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'commission_rate' => (int) $this->commission_rate,
            'status' => $this->status,
        ];
    }



    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
