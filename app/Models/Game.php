<?php

namespace App\Models;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Game extends BaseModel implements Auditable
{
    use  AuditableTrait;
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
        'game_category_id',
        'sort_order',


        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',

    ];

    protected $casts = [
        'platform' => 'array'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        });

        return $query;
    }

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id', 'id');
    }

}
