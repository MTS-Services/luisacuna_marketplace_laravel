<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class WithdrawalDocument extends AuditBaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'withdrawal_request_id',
        'verified_by',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'verified_at',


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
