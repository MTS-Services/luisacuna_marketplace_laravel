<?php
 
namespace App\Models;
 
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
 
class Hero extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //
 
    protected $fillable = [
        'sort_order',
        'title',
        'content',
        'action_title',
        'action_url',
        'image',
        'target',
        'status',
 
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