<?php

namespace App\Models;


use App\Models\AuditBaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Country extends AuditBaseModel implements Auditable
{
     use  AuditableTrait;

    protected $fillable = [
        'sort_order',
        'name',
        'code',
        'phone_code',
        'currency',
        'is_active',

        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function kycSettings()
    {
        return $this->hasMany(CountryKycSetting::class);
    }
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('phone_code', 'like', "%{$search}%")
                ->orWhere('currency', 'like', "%{$search}%");
        });
    }
    public function scopeFilder($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('is_active', $status));
        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */



    
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
}
