<?php

namespace App\Models;

use App\Enums\CurrencyStatus;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Currency extends BaseModel implements Auditable
{
    use Searchable, AuditableTrait;

    protected $fillable = [
        'sort_order',
        'code',
        'symbol',
        'name',
        'exchange_rate',
        'decimal_places',
        'status',
        'is_default',

        'restored_at',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => CurrencyStatus::class,
        'restored_at' => 'datetime',
        // 'exchange_rate' => 'decimal:15,2',
        // 'decimal_places' => 'integer',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function products()
    {
        return $this->hasMany(Product::class, 'currency_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', CurrencyStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', CurrencyStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['code'] ?? null,
                fn($q, $code) =>
                $q->where('code', 'like', "%{$code}%")
            )
            ->when(
                $filters['is_default'] ?? null,
                fn($q, $isDefault) =>
                $q->where('is_default', $isDefault)
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name', 'code', 'symbol'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'symbol' => $this->symbol,
            'exchange_rate' => (float) $this->exchange_rate,
            'decimal_places' => (int) $this->decimal_places,
            'status' => $this->status,
            'is_default' => $this->is_default,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
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
