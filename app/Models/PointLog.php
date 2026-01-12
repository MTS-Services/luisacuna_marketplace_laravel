<?php

namespace App\Models;

use App\Enums\PointType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use OwenIt\Auditing\Contracts\Auditable;

class PointLog extends BaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'user_id',

        'source_id',
        'source_type',

        'points',
        'notes',
        'type'

    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'points' => 'integer',
        'type' => PointType::class
    ];

    /* ==================================================================
                            RELATIONSHIPS
    ================================================================== */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function source(): MorphTo
    {
        return $this->morphTo();
    }


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
