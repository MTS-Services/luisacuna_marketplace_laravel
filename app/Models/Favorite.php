<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AuditableTrait;
use App\Models\BaseModel;
use App\Models\favorable;

class Favorite extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sort_order',
        'favorable_type',
        'favorable_id',



        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',

    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'user_id' => 'integer',
        'favorable_type' => 'string',
        'favorable_id' => 'integer',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /**
     * Get the parent model (Product, Post, etc.)
     */
    public function favorable()
    {
        return $this->morphTo();
    }

    /**
     * Favorite belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
}
