<?php

namespace App\Models;

use App\Enums\CalculationType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends BaseModel
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',

        'correlation_id',
        'transaction_id',
        'user_id',

        'type',
        'status',
        'calculation_type',

        'amount',
        'fee_amount',
        'net_amount',
        'currency',

        'balance_snapshot',

        'payment_gateway',
        'gateway_transaction_id',
        'order_id',

        'source_id',
        'source_type',

        'metadata',
        'notes',
        'failure_reason',
        'processed_at',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'source_id' => 'integer',
        'type' => TransactionType::class,
        'status' => TransactionStatus::class,
        'calculation_type' => CalculationType::class,
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    // Boot method to auto-generate transaction_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_id)) {
                $transaction->transaction_id = generate_transaction_id_hybrid();
            }

            // Calculate net amount if not set
            if ($transaction->net_amount == 0) {
                $transaction->net_amount = $transaction->amount - $transaction->fee_amount;
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

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
    /* SCOPES */

    public function scopeCompleted($query)
    {
        return $query->where('status', TransactionStatus::PAID);
    }

    public function scopePending($query)
    {
        return $query->where('status', TransactionStatus::PENDING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', TransactionStatus::FAILED);
    }

    public function scopeByType(Builder $query, TransactionType $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByGateway(Builder $query, string $gateway)
    {
        return $query->where('payment_gateway', $gateway);
    }

    public function scopeForOrder(Builder $query, int $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeForUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['wallet_id'])) {
            $walletId = $filters['wallet_id'];
            $query->whereHas('walletTransaction', function (Builder $q) use ($walletId) {
                $q->where('wallet_id', $walletId);
            });
        }

        if (isset($filters['user_id'])) {
            $query->forUser($filters['user_id']);
        }

        if (isset($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_gateway'])) {
            $query->byGateway($filters['payment_gateway']);
        }

        if (isset($filters['order_id'])) {
            $query->forOrder($filters['order_id']);
        }

        return $query;
    }

    public function scopeValided(Builder $query)
    {
        $query->whereNotIn('status', [
            TransactionStatus::FAILED,
            TransactionStatus::PENDING,
        ]);
    }

    /* HELPER METHODS */

    public function isCompleted(): bool
    {
        return $this->status === TransactionStatus::PAID;
    }

    public function isPending(): bool
    {
        return $this->status === TransactionStatus::PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === TransactionStatus::FAILED;
    }

    public function markAsCompleted(?string $gatewayTransactionId = null): bool
    {
        return $this->update([
            'status' => TransactionStatus::PAID,
            'gateway_transaction_id' => $gatewayTransactionId ?? $this->gateway_transaction_id,
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed(?string $reason = null): bool
    {
        return $this->update([
            'status' => TransactionStatus::FAILED,
            'failure_reason' => $reason,
            'processed_at' => now(),
        ]);
    }

    public function markAsProcessing(): bool
    {
        return $this->update([
            'status' => TransactionStatus::PROCESSING,
        ]);
    }
}
