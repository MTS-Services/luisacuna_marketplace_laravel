<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class UserNotificationSetting extends BaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'user_id',

        'new_order',
        'new_message',
        'order_update',
        'dispute_update',
        'payment_update',
        'withdrawal_update',
        'verification_update',
        'boosting_offer',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'new_order' => 'boolean',
        'new_message' => 'boolean',
        'order_update' => 'boolean',
        'dispute_update' => 'boolean',
        'payment_update' => 'boolean',
        'withdrawal_update' => 'boolean',
        'verification_update' => 'boolean',
        'boosting_offer' => 'boolean',
        'user_id' => 'integer',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
