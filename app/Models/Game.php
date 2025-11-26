<?php

namespace App\Models;

use App\Enums\GameStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Models\Type;

class Game extends AuditBaseModel implements Auditable
{
    use  AuditableTrait, Searchable;
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

    public function servers()
    {
           
        return $this->belongsToMany(
            Server::class,
            'game_servers',
            'game_id',
            'server_id'
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
    public function types()
    {
        return $this->belongsToMany(
            Type::class,
            'game_types',
            'game_id',
            'type_id'
        );
    }
    public function rarities()
    {
        return $this->belongsToMany(
            Rarity::class,
            'game_rarities',
            'game_id',
            'rarity_id'
        );
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
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );

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
