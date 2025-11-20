<?php

namespace App\Models;

use App\Enums\GameStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Game extends AuditBaseModel implements Auditable
{
    use  AuditableTrait, Searchable;
    //

    protected $fillable = [

        'name',
        'slug',
        'description',
        'developer',
        'publisher',
        'release_date',
        'platform',
        'logo',
        'banner',
        'thumbnail',
        'is_featured',
        'is_trending',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        // 'game_category_id',
        'status',   
        'category_id',
        'sort_order',


        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'roster_id',

    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'platform' => 'array',
        'status' => GameStatus::class,
        'restored_at' => 'datetime',
    ];


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    //
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product()
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
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );

        // $query->when(
        //     $filters['status'] ?? null,
        //     fn($query, $status) => $query->where('status', $status), function ($query, $status) {
        //     $query->where('status', $status);
        // });

        // $query->when($filters['search'] ?? null, function ($query, $search) {
        //     $query->search($search);
        // });

        // return $query;
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
            'is_trending' => $this->is_trending,
            'is_featured' => $this->is_featured,
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
