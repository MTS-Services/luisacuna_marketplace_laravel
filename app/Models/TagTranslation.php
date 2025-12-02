<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class TagTranslation extends BaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        'sort_order',
        'language_id',
        'tag_id',
        'name',

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
