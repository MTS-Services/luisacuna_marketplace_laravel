<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends AuditBaseModel implements Auditable
{
    use AuditableTrait, SoftDeletes;

    protected $fillable = [
        'sort_order',
        'payment_id', // ADDED
        'user_id',
        'name',
        'email_address',
        'payment_gateway',
        'payment_method_id', // ADDED
        'payment_intent_id', // ADDED
        'transaction_id', // ADDED
        'amount',
        'currency',
        'status',
        'card_brand', // ADDED
        'card_last4', // ADDED
        'order_id',
        'metadata',
        'notes',
        'paid_at', // ADDED
        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'restorer_id',
        'restorer_type',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'amount' => 'decimal:2',
        'status' => PaymentStatus::class,
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    // Boot method to auto-generate payment_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_id)) {
                $payment->payment_id = generate_payment_id();
            }
        });
    }

    /* RELATIONSHIPS */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'source');
    }

    /* SCOPES */
    public function scopeSuccessful($query)
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

    /* HELPER METHODS */
    public function isSuccessful(): bool
    {
        return $this->status === PaymentStatus::COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status === PaymentStatus::PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === PaymentStatus::FAILED;
    }

    public function markAsCompleted(?string $transactionId = null): bool
    {
        return $this->update([
            'status' => PaymentStatus::COMPLETED,
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed(?string $reason = null): bool
    {
        return $this->update([
            'status' => PaymentStatus::FAILED,
            'notes' => $reason,
        ]);
    }
}
