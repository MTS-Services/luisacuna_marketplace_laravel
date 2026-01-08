<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Wallet extends BaseModel
{
    protected $fillable = [
        'sort_order',

        'user_id',
        'currency_code',
        'balance',
        'locked_balance',
        'pending_balance',

        'total_deposits',
        'total_withdrawals',

        'last_deposit_at',
        'last_withdrawal_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'locked_balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',

        'total_deposits' => 'decimal:2',
        'total_withdrawals' => 'decimal:2',
        'last_deposit_at' => 'datetime',
        'last_withdrawal_at' => 'datetime',
    ];

    /* ==============================================================
                RELATIONSHIPS - START
     ============================================================== */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
