<?php
 
namespace App\Models;

use App\Enums\RankStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
 
class Rank extends BaseModel implements Auditable
{
    use   AuditableTrait;
    /** @use HasFactory<\Database\Factories\RankFactory> */
    use HasFactory;
 
    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'minimum_points',
        'maximum_points',
        'icon',
        'status',
        'initial_assign',

        'created_by',
        'updated_by', 
        'deleted_by',
        'restored_by',

 
      //here AuditColumns 
    ];
 
    protected $hidden = [
        //
        'id',

    ];
 
    protected $casts = [
        //
        'status'    => RankStatus::class,
        'restored_at' => 'datetime',
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