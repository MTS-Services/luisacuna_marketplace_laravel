<?php

namespace App\Models;

use App\Enums\GameCategoryStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class GameCategory extends BaseModel implements Auditable
{
    use  AuditableTrait;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'status',

        'sort_order',
        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',
    ];

    protected $casts = [
        'status' => GameCategoryStatus::class
    ];

    // Scope    
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
}
