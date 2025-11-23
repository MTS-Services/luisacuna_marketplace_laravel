<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\Translatable;

class Post extends BaseModel
{
    use Translatable;

    protected $fillable = [
        'sort_order',
        'title',
        'content',
        'description',
        'language',
        'original_language'
        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    /**
     * Define which attributes should be translated
     */
    protected $translatable = [
        'title',
        'content',
        'description'
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
