<?php

namespace App\Models;

use App\Enums\CurrencyStatus;
use Illuminate\Database\Eloquent\Model;

class Currency extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $fillable = [
        'code',
        'symbol',
        'name',
        'exchange_rate',
        'decimal_places',
        'status',
        'is_default',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected $casts = [
        'status' => CurrencyStatus::class,
        'is_default' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function baseExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'base_currency');
    }
    public function targetExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'target_currency');
    }
    public function baseExchangeRateHistories()
    {
        return $this->hasMany(ExchangeRateHistory::class, 'base_currency');
    }
    public function targetExchangeRateHistories()
    {
        return $this->hasMany(ExchangeRateHistory::class, 'target_currency');
    }
    public function referralSettings()
    {
        return $this->hasMany(ReferralSetting::class, 'currency_id');
    }
    public function userStatistics()
    {
        return $this->hasMany(UserStatistic::class , 'currency_id');
    }
    public function userReferrals()
    {
        return $this->hasMany(UserReferral::class, 'currency_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', CurrencyStatus::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', CurrencyStatus::INACTIVE);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('symbol', 'like', "%{$search}%");
        });
    }

    public function scopeFilder($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status));
        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */


    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }
    public function getStatusColorAttribute()
    {
        return $this->status->color();
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */


    public function is_active(): bool
    {
        return $this->status === CurrencyStatus::ACTIVE;
    }
    public function activate(): void
    {
        $this->update(['status' => CurrencyStatus::ACTIVE]);
    }
    public function deactivate(): void
    {
        $this->update(['status' => CurrencyStatus::INACTIVE]);
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
