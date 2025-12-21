<?php

namespace App\Models;

use App\Models\Conversation;
use App\Enums\ParticipantRole;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ConversationParticipant extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'id',
        'sort_order',
        'conversation_id',
        'participant_id',
        'participant_type',
        'participant_role',
        'joined_at',
        'left_at',
        'is_active',
        'last_read_at',
        'notification_enabled',

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
        'participant_role' => ParticipantRole::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function conversation()
    {
        return $this->belongsTo(Conversation::class,  'conversation_id', 'id');
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class,  'user_id', 'id');
    // }

    public function participant()
    {
        return $this->morphTo();
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
