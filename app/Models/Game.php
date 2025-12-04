<?php

namespace App\Models;

use App\Enums\GameStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Models\Type;
use App\Traits\HasTranslations;
use Illuminate\Testing\Fluent\Concerns\Has;

class Game extends AuditBaseModel implements Auditable
{
    use  AuditableTrait, Searchable, HasTranslations;
    //

    protected $fillable = [

        'name',
        'slug',
        'description',

        'logo',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',



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
    ];


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    //


    public function categories()
    {
        // 1. Pass the related model (Category::class)
        // 2. Pass the name of your pivot table ('game_categories')
        // 3. Pass the foreign key on the pivot table for THIS model ('game_id')
        // 4. Pass the foreign key on the pivot table for the OTHER model ('category_id')
        return $this->belongsToMany(
            Category::class,
            'game_categories',
            'game_id',
            'category_id'
        );
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
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });
        return $query;
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
