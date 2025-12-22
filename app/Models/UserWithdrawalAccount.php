<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class UserWithdrawalAccount extends AuditBaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'user_id',
        'withdrawal_method_id',
        'account_name',
        'account_data',
        'is_default',
        'is_vsrified',
        'status',
        'note',
        'verified_at',
        'last_used_at',

        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',

        'creater_type',
        'updater_type',
        'deleter_type',
        'restorer_type',

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
