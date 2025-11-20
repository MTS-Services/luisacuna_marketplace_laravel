<?php

namespace App\Models;

use App\Http\Payment\PaymentManager;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class PaymentGateway extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'icon',
        'data',
        'status',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }

    public function paymentMethod()
    {
        return app(PaymentManager::class)->getPaymentMethodOrFail($this->slug, $this);
    }

    public function isSupported(): bool
    {
        return app(PaymentManager::class)->hasPaymentMethod($this->slug);
    }

    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
