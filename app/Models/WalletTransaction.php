<?php

namespace App\Models;

use App\Enums\CalculationType;
use App\Enums\WalletTransactionType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use OwenIt\Auditing\Contracts\Auditable;

class WalletTransaction extends BaseModel
{

    protected $fillable = [
        'sort_order',

        'wallet_id',
        'transaction_id',
        'type',
        'calculation_type',
        'amount',
        'balance_after',
        'balance_before',
        'currency_code',
        'notes',
        'source_id',
        'source_type',
        // 'reference_id',

    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'type' => WalletTransactionType::class,
        'calculation_type' => CalculationType::class,

    ];

    /* ==============================================================
                RELATIONSHIPS - START
     ============================================================== */

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    /* ==============================================================
                RELATIONSHIPS - END
     ============================================================== */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
