<?php

namespace App\Models;


use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class GameTranslation extends BaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        "sort_order",
        "language_id",
        "game_id",
        "name",
        "description",


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

    //
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
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
