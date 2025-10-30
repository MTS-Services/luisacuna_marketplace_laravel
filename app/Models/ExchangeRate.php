<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ExchangeRate extends BaseModel implements Auditable
{
    use  AuditableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $fillable = [
        'base_currency',
        'target_currency',
        'rate',
        'last_updated_at',


        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected $casts = [
        'last_updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class, 'base_currency');
    }

    public function targetCurrency()
    {
        return $this->belongsTo(Currency::class, 'target_currency');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('base_currency', 'like', "%{$search}%")
                ->orWhere('target_currency', 'like', "%{$search}%");
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
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
