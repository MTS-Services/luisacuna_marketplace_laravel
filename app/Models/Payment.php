<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;
use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
 
#[ObservedBy([PaymentObserver::class])]
class Payment extends AuditBaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'payment_id',
        'user_id',
        'order_id',
        'name',
        'email_address',
        'payment_gateway',
        'payment_method_id',
        'payment_intent_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'card_brand',
        'card_last4',
        'metadata',
        'notes',
        'paid_at',

        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'restorer_id',
        'restorer_type',
        'restored_at',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'source_id')
            ->where('source_type', self::class);
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
        $updated = $this->update([
            'status' => PaymentStatus::COMPLETED,
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'paid_at' => now(),
        ]);

        if ($updated) {
            $this->createTransaction();
        }

        return $updated;
    }

    public function markAsFailed(?string $reason = null): bool
    {
        return $this->update([
            'status' => PaymentStatus::FAILED,
            'notes' => $reason,
        ]);
    }

    /**
     * Create a transaction record for this payment
     */
    // protected function createTransaction(): void
    // {
    //     if ($this->transaction()->exists()) {
    //         return; // Transaction already exists
    //     }

    //     Transaction::create([
    //         'user_id' => $this->user_id,
    //         'order_id' => $this->order_id,
    //         'type' => \App\Enums\TransactionType::PAYMENT,
    //         'status' => \App\Enums\TransactionStatus::PAID,
    //         'amount' => $this->amount,
    //         'currency' => $this->currency,
    //         'payment_gateway' => $this->payment_gateway,
    //         'gateway_transaction_id' => $this->transaction_id,
    //         'source_id' => $this->id,
    //         'source_type' => self::class,
    //         'fee_amount' => 0, // Calculate if needed
    //         'net_amount' => $this->amount,
    //         'metadata' => [
    //             'payment_id' => $this->payment_id,
    //             'payment_method_id' => $this->payment_method_id,
    //             'payment_intent_id' => $this->payment_intent_id,
    //         ],
    //         'processed_at' => $this->paid_at,
    //     ]);
    // }
}
