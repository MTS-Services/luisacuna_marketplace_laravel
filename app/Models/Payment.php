<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'user_id',
        'order_id',
        'name',
        'email_address',
        'address',
        'postal_code',
        'reference',
        'notes',
        'payment_gateway',
        'transaction_id',
        'payment_intent_id',
        'amount',
        'currency',
        'status',
        'description',
        'metadata',
        'completed_at',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'metadata' => 'array',
        'completed_at' => 'datetime',
        'amount' => 'decimal:2',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', PaymentStatus::COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::PENDING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', PaymentStatus::FAILED);
    }

    public function scopeByGateway($query, string $gateway)
    {
        return $query->where('payment_gateway', $gateway);
    }
}
