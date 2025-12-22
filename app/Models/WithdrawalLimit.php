<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class WithdrawalLimit extends AuditBaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'withdrawal_method_id',
        'is_active',
        'daily_limit',
        'weekly_limit',
        'monthly_limit',
        'per_transaction_limit',
        'max_daily_requests',
        'max_weekly_requests',
        'max_monthly_requests',
        'priority',


        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',

        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
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


}
