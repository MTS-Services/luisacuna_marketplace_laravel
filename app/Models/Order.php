<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'unit_price',
        'total_amount',
        'tax_amount',
        'grand_total',
        'currency',
        'payment_method',
        'quantity',
        'notes',
        'completed_at',

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
        'customer_id' => 'integer',
        'source_id' => 'integer',
        'status' => OrderStatus::class,
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /* RELATIONSHIPS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function source(): MorphTo
    {
        return $this->morphTo('source');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'order_id')->latestOfMany();
    }

    public function successfulPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id')
            ->where('status', \App\Enums\PaymentStatus::COMPLETED);
    }

    public function completedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'order_id')
            ->where('status', \App\Enums\TransactionStatus::PAID)
            ->where('type', \App\Enums\TransactionType::PURCHSED);
    }

    /* HELPER METHODS */

    public function filter(Builder $query, array $filters): Builder
    {
        return $query;
    }

    public function hasSuccessfulPayment(): bool
    {
        return $this->successfulPayments()->exists();
    }

    public function getTotalPaid(): float
    {
        return (float) $this->completedTransactions()->sum('amount');
    }

    public function getRemainingAmount(): float
    {
        return max(0, $this->grand_total - $this->getTotalPaid());
    }

    public function isFullyPaid(): bool
    {
        return $this->getTotalPaid() >= $this->grand_total;
    }

    public function isPartiallyPaid(): bool
    {
        $totalPaid = $this->getTotalPaid();
        return $totalPaid > 0 && $totalPaid < $this->grand_total;
    }

    public function getPaymentProgress(): float
    {
        if ($this->grand_total == 0) {
            return 0;
        }
        return min(100, ($this->getTotalPaid() / $this->grand_total) * 100);
    }

    /**
     * Check if order can accept more payments
     */
    public function canAcceptPayment(): bool
    {
        return !$this->isFullyPaid() &&
            $this->status !== OrderStatus::CANCELLED &&
            $this->status !== OrderStatus::REFUNDED;
    }

    /**
     * Update order status based on payment progress
     */
    public function updateStatusBasedOnPayment(): void
    {
        if ($this->isFullyPaid()) {
            $this->update([
                'status' => OrderStatus::COMPLETED,
                'completed_at' => now(),
            ]);
        } elseif ($this->isPartiallyPaid()) {
            $this->update([
                'status' => OrderStatus::PARTIALLY_PAID,
            ]);
        }
    }

    public function scopeFilter(Builder $query, array $filters)
    {
       
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('order_id', 'like', '%' . $search . '%')
                    ->orWhere('notes', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['user_id'] ?? null, function ($query, $userId) {
            $query->where('user_id', $userId);
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        // product owner filter (logged in user is the creator)
        $query->when($filters['seller_id'] ?? null, function ($query, $ownerId) {
            $query->whereHas('source', function ($q) use ($ownerId) {
                $q->where('user_id', $ownerId);
            });
        });

        // exclude buyer = owner
        $query->when($filters['buyer_id'] ?? null, function ($query, $ownerId) {
            $query->where('user_id', '!=', $ownerId);
        });

        $query->when($filters['created_at'] ?? null, function ($query, $created_at) {
            $query->whereDate('created_at', $created_at);
        });

        return $query;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
