<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;

class OfferItem extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'title',
        'description',
        'image',
        'delivery_time',
        'delivery_method_id',
        'quantity',
        'terms_condition',
        'agreement',
        'price',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'delivery_time'    => 'datetime',
        'terms_condition'  => 'boolean',
        'agreement'        => 'boolean',
        'price'            => 'decimal:2',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class, 'delivery_method_id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'delivery_time_formatted',
        ]);
    }
    public function getDeliveryTimeFormattedAttribute($value)
    {
         return dateTimeFormat($this->attributes['delivery_time']);
    }


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['sluge'] ?? null,
                fn($q, $sluge) =>
                $q->where('sluge', 'like', "%{$sluge}%")
            );
    }
}
