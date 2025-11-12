<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\ProductStatus;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use App\Enums\ProductsVisibility;
use App\Enums\ProductsDeliveryMethod;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Product extends BaseModel implements Auditable
{
    use  AuditableTrait, Searchable;

    protected $fillable = [
        'sort_order',
        'seller_id',
        'game_id',
        'product_type_id',
        'title',
        'slug',
        'description',
        'price',
        'currency_id',
        'discount_percentage',
        'discounted_price',
        'stock_quantity',
        'min_purchase_quantity',
        'max_purchase_quantity',
        'unlimited_stock',
        'delivery_method',
        'delivery_time_hours',
        'auto_delivery_content',
        'server_id',
        'platform',
        'region',
        'specifications',
        'requirements',
        'status',
        'is_featured',
        'is_hot_deal',
        'visibility',
        'total_sales',
        'total_revenue',
        'view_count',
        'favorite_count',
        'average_rating',
        'total_reviews',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'meta_title',
        'meta_description',
        'meta_keywords',


        'creater_type',
        'updater_type',
        'deleter_type',
        'restorer_type',


        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',

        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'delivery_method' => ProductsDeliveryMethod::class,
        'status' => ProductStatus::class,
        'visibility' => ProductsVisibility::class,
        'reviewed_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */





    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::INACTIVE);
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
                $filters['sluge'] ?? null,
                fn($q, $sluge) =>
                $q->where('sluge', 'like', "%{$sluge}%")
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
