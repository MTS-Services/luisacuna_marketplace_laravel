<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Enums\ActiveInactiveEnum;
use App\Traits\HasTranslations;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Product extends BaseModel implements Auditable
{
    use   AuditableTrait, HasTranslations;
    //

    protected $fillable = [
        'sort_order',

        'user_id',
        'category_id',
        'game_id',

        'slug',
        'description',
        'price',
        'name',
        'quantity',
        'minimum_offer_quantity',
        'status',
        'platform_id',
        'delivery_timeline',
        'delivery_method',

        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'restorer_id',
        'restorer_type',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'status' => ActiveInactiveEnum::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function product_configs()
    {
        return $this->hasMany(ProductConfig::class, 'product_id', 'id');
    }

    public function productTranslations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'source');
    }

    public function feedbacks()
    {
        return $this->hasManyThrough(
            Feedback::class,
            Order::class,
            'source_id',    // foreign key on orders
            'order_id',     // foreign key on feedbacks
            'id',           // local key on products
            'id'            // local key on orders
        )
            ->where('orders.source_type', Product::class);
    }

    public function getTranslationConfig(): array
    {
       
        return [
            'fields' => ['name', 'description', 'delivery_timeline', 'delivery_method', ],
            'relation' => 'productTranslations',
            'model' => ProductTranslation::class,
            'foreign_key' => 'product_id',
            'field_mapping' => [
                'name' => 'name',
                'description' => 'description',
                'delivery_timeline' => 'delivery_timeline',
                'delivery_method' => 'delivery_method'
            ],
        ];
    }


    public function translatedName($languageIdOrLocale): string
    {
        return $this->getTranslated('name', $languageIdOrLocale) ?? $this->name;
    }

    public function translatedDescription($languageIdOrLocale): string
    {
        return $this->getTranslated('description', $languageIdOrLocale) ?? $this->description;
    }
    public function translatedDeliveryTimeline($languageIdOrLocale): string
    {
        return $this->getTranslated('delivery_timeline', $languageIdOrLocale) ?? $this->delivery_timeline;
    }
    public function translatedDeliveryMethod($languageIdOrLocale): string
    {
        return $this->getTranslated('delivery_method', $languageIdOrLocale) ?? $this->delivery_method;
    }

    public function scopeFilter(Builder $query, $filters): Builder
    {

        if ($filters['gameSlug'] ?? null) {
            $query->whereHas('games', function ($q) use ($filters) {
                $q->where('games.slug', $filters['gameSlug']);
            });
        }
        if ($filters['categorySlug'] ?? null) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('categories.slug', $filters['categorySlug']);
            });
        }

        if ($filters['game_id'] ?? null) {
            $query->where('game_id', $filters['game_id']);
        }

        if ($filters['user_id'] ?? null) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($filters['status'] ?? null) {
            $query->where('status', $filters['status']);
        }

        $query->when($filters['skipSelf'] ?? null, function ($query, $skipSelf) {
            $query->where('user_id', '!=', user()->id ?? 0);
        });
    // Platform is slug of Platform table
        $query->when($filters['platform_id'] ?? null, function ($query, $platform_id) {
            $query->where('platform_id', $platform_id);
        });

        $query->when($filters['delivery_timeline'] ?? null, function ($query, $delivery_timeline) {
            $query->where('delivery_timeline', $delivery_timeline);
        });

        $query->when($filters['min_price'] ?? null, function ($query, $min_price) {
            $query->where('price', ">=", $min_price);
        });

        $query->when($filters['max_price'] ?? null, function ($query, $max_price) {
            $query->where('price', "<=", $max_price);
        });

        $query->when($filters['positive_reviews'] ?? null, function ($query) {
            // 1. Add a virtual column for the count via a subquery
            $query->addSelect([
                'seller_positive_count' => \App\Models\Feedback::selectRaw('count(*)')
                    ->whereColumn('target_user_id', 'products.user_id')
                    ->where('type', 'positive')
            ]);

            // 2. Order by that virtual column (highest first, then 0s)
            $query->orderBy('seller_positive_count', 'desc');
        });

        $query->when($filters['top_sold'] ?? null, function ($query) {
            $query->withCount([
                'orders as completed_orders_count' => function ($q) {
                    $q->where('status', \App\Enums\OrderStatus::COMPLETED);
                }
            ])->orderByDesc('completed_orders_count');
        });

        if (!empty($filters['isStocked'])) {
            $query->where('quantity', '>', 0);
        }

        if ($filters['user_id'] ?? null) {
            $query->where('user_id', $filters['user_id']);
        }

        if($filters['game_tag'] ?? null) {
             $query->whereHas('game.tags', function ($q) use ($filters) {
            $q->where('slug', $filters['game_tag']);
          });
        }

        if($filters['filter_by_config'] ?? null) {
            $query->whereHas('product_configs', function ($q) use ($filters) {
                $q->where('value', $filters['filter_by_config']);
            });
        }

       if ($filters['filter_by_tag'] ?? null) {
            $query->whereHas('platform', function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['filter_by_tag'] . '%');
            })
            ->orWhereHas('product_configs', function ($q) use ($filters) {
                $q->where('value', 'LIKE', '%' . $filters['filter_by_tag'] . '%');
            });
        }



        return $query;
    }



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
        End of RELATIONSHIPS
=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
#[SearchUsingPrefix(['name', 'description', 'delivery_timeline', 'price', 'game_name', 'platform_name', 'config'])]
public function toSearchableArray(): array
{
    $this->loadMissing([
        'game:id,name',
        'platform:id,name',
        'product_configs:product_id,value'
    ]);
    
    return [
        'name' => $this->name,
        'description' => $this->description,
        'price' => (float) $this->price,
        'delivery_timeline' => $this->delivery_timeline,
        'game_name' => $this->game?->name ?? '',
        'platform_name' => $this->platform?->name ?? '',
        'config' => $this->product_configs
            ?->pluck('value')
            ->filter()
            ->values()
            ->toArray() ?? [],
    ];
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
}
