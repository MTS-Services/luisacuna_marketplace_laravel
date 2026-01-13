<?php
 
namespace App\Models;

use App\Enums\HelpfulType;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
 
class Helpful extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //
 
    protected $fillable = [
        'sort_order',
        'ip_address',
        'cms_id',
        'user_id',
        'type',
 
      //here AuditColumns 
    ];
 
    protected $hidden = [
        //
    ];
 
    protected $casts = [
        HelpfulType::class,
    ];
 
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
     //
     public function cms():BelongsTo
     {
         return $this->belongsTo(Cms::class, 'cms_id', 'id');
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