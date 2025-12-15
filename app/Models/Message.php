<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Message extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'id',
        'sort_order',
        'message_id',
        'sender_id',
        'receiver_id',

        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',
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

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }


    public function message_participants()
    {
        return $this->hasMany(MessageParticipant::class, 'message_id', 'id');
    }


    /**
     * ✅ Relationship to OrderMessage
     */
    public function orderMessages()
    {
        return $this->hasMany(OrderMessage::class, 'message_id', 'id');
    }

    /**
     * ✅ Latest order message
     */
    public function latestOrderMessage()
    {
        return $this->hasOne(OrderMessage::class, 'message_id', 'id')->latestOfMany();
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
