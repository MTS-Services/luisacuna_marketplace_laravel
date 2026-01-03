<?php

namespace App\Models;

use App\Enums\GameStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends AuditBaseModel implements Auditable
{
    use  AuditableTrait, Searchable, HasTranslations;
    //

    protected $fillable = [

        'name',
        'slug',
        'description',

        'status',
        'logo',
        'banner',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'sort_order',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',

        'created_at',
        'deleted_at',
        'restored_at',
        'updated_at',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        // 'platform' => 'array',
        'status' => GameStatus::class,
        'restored_at' => 'datetime',
        'meta_keywords' => 'array',
    ];


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    //


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'game_categories',
            'game_id',
            'category_id'
        )->withTimestamps();
    }

    public function gameCategories(): HasMany
    {
        return $this->hasMany(GameCategory::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(
            Platform::class,
            'game_platforms',
            'game_id',
            'platform_id'
        );
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'game_tags',
            'game_id',
            'tag_id'
        );
    }

    public function gameTranslations()
    {
        return $this->hasMany(GameTranslation::class, 'game_id', 'id');
    }


    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['name', 'description'],
            'relation' => 'gameTranslations',
            'model' => GameTranslation::class,
            'foreign_key' => 'game_id',
            'field_mapping' => [
                'name' => 'name',
                'description' => 'description',
            ],
        ];
    }

    public function gameConfig()
    {
        return $this->hasMany(GameConfig::class, 'game_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'game_id', 'id');
    }


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
            Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    //

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', GameStatus::ACTIVE);
    }

   
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', GameStatus::INACTIVE);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', GameStatus::UPCOMING);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if(!empty($filters['relations'])){

            $query->with($filters['relations']);
        }

         // Add withCount for products
        if(!empty($filters['withProductCount']) && !empty($filters['category'])) {
            $category = Category::where('slug', $filters['category'])->first();
            if($category) {
                $query->withCount(['products' => function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                }]);
            }
        }

        $query->when($filters['tag'] ?? null, function ($query, $tag) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.slug', $tag);
            }) ;    
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })

        ->when($filters['category'] ?? '', function ($query, $category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.slug', $category);
            });

        })
        ->when($filters['tag'] ?? null, function ($query, $tag) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.slug', $tag);
            });
        })
        ;
        return $query;
    }
     public function scopeByCategory(Builder $query , string $Categoryslug): Builder
    {
        return $query->whereHas('categories', function ($q) use ($Categoryslug) {
            $q->where('categories.slug', $Categoryslug);
        });
    }

    public function scopeWithCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    public function scopeWithCategories($query, array $categoryIds)
    {
        return $query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        }, '=', count($categoryIds));
    }

    public function hasCategory(int $categoryId): bool
    {
        return $this->categories()->where('categories.id', $categoryId)->exists();
    }

    public function getCategoriesCountAttribute(): int
    {
        return $this->categories()->count();
    }

    // public function scopeSearch($query, $search)
    // {
    //     return $query->where(function ($q) use ($search) {
    //         $q->where('name', 'like', "%{$search}%")
    //             ->orWhere('description', 'like', "%{$search}%");
    //     });
    // }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
        Scount Search Configuartion
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    //

    #[SearchUsingPrefix(['id', 'name',])]
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable()
    {
        return is_null($this->deleted_at);
    }

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);
    //     $this->appends = array_merge(parent::getAppends(), [
    //         'status_label',
    //         'status_color',
    //     ]);
    // }

}
