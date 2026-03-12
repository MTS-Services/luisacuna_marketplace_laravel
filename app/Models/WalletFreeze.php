<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletFreeze extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'order_id',
        'user_id',
        'wallet_id',
        'amount',
        'currency_code',
        'status',
        'reason',
        'frozen_at',
        'released_at',
        'refunded_at',
        'expired_at',
        'cancelled_at',
        'partially_refunded_at',
        'hold_at',
        'split_at',
        'is_frozen',

        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',

        // here AuditColumns
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'split_at' => 'datetime',
        'released_at' => 'datetime',
        'refunded_at' => 'datetime',
        'expired_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'partially_refunded_at' => 'datetime',
        'hold_at' => 'datetime',
        'split_at' => 'datetime',
        'is_frozen' => 'boolean',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

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
}
