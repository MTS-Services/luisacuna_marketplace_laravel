<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Enums\ActiveInactiveEnum;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Product extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',

        'user_id',
        'category_id',
        'game_id',

        'slug',
        'name',
        'description',
        'price',
        'name',
        'quantity',
        'minimum_offer_quantity',
        'delivery_method',
        'status',
        'platform_id',
        'delivery_timeline',

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


    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['name', 'description', 'delivery_timeline','price', 'quantity'],
            'relation' => 'productTranslations',
            'model' => ProductTranslation::class,
            'foreign_key' => 'product_id',
            'field_mapping' => [
                'name' => 'name',
                'description' => 'description',
                'delivery_timeline' => 'delivery_timeline',
                'price' => 'price',
                'quantity' => 'quantity',
            ],
        ];
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

        if ($filters['user_id'] ?? null) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($filters['page'] ?? null) {
            $query->where('status', $filters['status']);
        }

        $query->when($filters['skipSelf'] ?? null, function ($query, $skipSelf) {
                $query->where('id', '!=', user()->id ?? 0);

        });

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

        if (!empty($filters['isStocked'])) {
            $query->where('quantity', '>', 0);
        }

        if ($filters['user_id'] ?? null) {
            $query->where('user_id', $filters['user_id']);
        }
        return $query;
    }



/* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
        End of RELATIONSHIPS
=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
#[SearchUsingPrefix(['id', 'name', 'description', 'delivery_timeline', 'price'])]
public function toSearchableArray(): array
{
    // Load the game with its tags
    if (!$this->relationLoaded('game')) {
        $this->load(['game:id,name', 'game.tags:id,name']);
    }
    
    // Since there's only ONE game, just pluck the tag names directly
    $gameTags = $this->game?->tags->pluck('name')->all() ?? [];

    return [
        'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'price' => (double) $this->price,
        'delivery_timeline' => $this->delivery_timeline,
        'game_tags' => $gameTags,
        'game_name' => $this->game?->name,
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
