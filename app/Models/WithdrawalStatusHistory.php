<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class WithdrawalStatusHistory extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'withdrawal_request_id',
        'from_status',
        'to_status',
        'changed_by',
        'notes',
        'metadata',
        'created_at',

      //here AuditColumns
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

    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(WithdrawalRequest::class, 'withdrawal_request_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
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
