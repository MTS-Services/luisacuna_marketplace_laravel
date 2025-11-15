<?php
 
namespace App\Models;

use App\Enums\GameServerStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
 
class GameServer extends BaseModel implements Auditable
{
    use   AuditableTrait;
    /** @use HasFactory<\Database\Factories\GameServerFactory> */
    use HasFactory;
 
    protected $fillable = [
        'sort_order',
        'name',
        'status',
        'icon',
        'type',
        'region',

         'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
        //here AuditColumns 
    ];
 
    protected $hidden = [
        //
        'id',
    ];
 
    protected $casts = [
        //
        'status' => GameServerStatus::class,
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