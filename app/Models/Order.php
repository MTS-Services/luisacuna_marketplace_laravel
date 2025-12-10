<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

class Order extends AuditBaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'order_id',
        'user_id',
        'source_id',
        'source_type',
        'status',
        'total_amount',
        'tax_amount',
        'grand_total',
        'currency',
        'payment_method',
        'notes',

        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'restorer_id',
        'restorer_type',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'customer_id' => 'integer',
        'source_id' => 'integer',
        'status' => OrderStatus::class,
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function source()
    {
        return $this->morphTo('source');
    }


    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'order_id')->latestOfMany();
    }

    public function successfulPayment()
    {
        return $this->hasOne(Payment::class, 'order_id')
            ->where('status', \App\Enums\PaymentStatus::COMPLETED)
            ->latestOfMany();
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of HELPER METHODS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function filter(Builder $query, array $filters): Builder
    {
        return $query;
    }


    public function hasSuccessfulPayment(): bool
    {
        return $this->successfulPayment()->exists();
    }

    public function getTotalPaid(): float
    {
        return (float) $this->payments()
            ->where('status', \App\Enums\PaymentStatus::COMPLETED)
            ->sum('amount');
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['user_id'] ?? null, function ($query, $userId) {
            $query->where('user_id', $userId); // এটা important - logged in user এর order দেখাবে
        });


        // product owner filter (logged in user is the creator)
        $query->when($filters['product_creator_id'] ?? null, function ($query, $ownerId) {
            $query->whereHas('source', function ($q) use ($ownerId) {
                $q->where('user_id', $ownerId);   // product.owner_id = logged user
            });
        });

        // exclude buyer = owner
        $query->when($filters['product_creator_id'] ?? null, function ($query, $ownerId) {
            $query->where('user_id', '!=', $ownerId);   // buyer ≠ owner
        });

        return $query;
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of HELPER METHODS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
