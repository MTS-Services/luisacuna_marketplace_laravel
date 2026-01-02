<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Enums\ActiveInactiveEnum;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

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
            if ($skipSelf) {
                $query->where('id', '!=', user()->id ?? 0);
            }
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
