<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class BaseModel extends Model implements Auditable
{
    use HasFactory, Searchable, AuditableTrait;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $appends = [
        'created_at_human',
        'updated_at_human',

        'created_at_formatted',
        'updated_at_formatted',
    ];

    /* ================================================================
     |  Relationships
     ================================================================ */

    //  

    /* ================================================================
     |  Accessors
     ================================================================ */

    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at ? dateTimeHumanFormat($this->attributes['created_at']) : "N/A";
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return $this->updated_at ? dateTimeHumanFormat($this->attributes['updated_at'], $this->attributes['created_at']) : "N/A";
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at ? dateTimeFormat($this->attributes['created_at']) : "N/A";
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return $this->updated_at ? dateTimeFormat($this->attributes['updated_at'], $this->attributes['created_at']) : "N/A";
    }
}
