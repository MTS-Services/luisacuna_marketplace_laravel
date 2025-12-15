<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class OrderMessage extends AuditBaseModel implements Auditable
{
    use   AuditableTrait, Notifiable;
    //

    protected $fillable = [
        'sort_order',
        'message_id',
        'message',
        'attachments',
        'is_system_message',
        'seen_at',


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
        'attachments' => 'json',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    /**
     * User who created this message
     */
    public function creator()
    {
        return $this->morphTo('creater'); // 'creater' prefix ব্যবহার করুন
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
