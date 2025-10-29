<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $appends = [
        'created_at_human',
        'updated_at_human',
        'deleted_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
    ];

    /* ================================================================
     |  Relationships
     ================================================================ */


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'name');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->select('id', 'name');
    }
    
    public function creater()
    {
        return $this->morphTo();
    }

    public function updater()
    {
        return $this->morphTo();
    }

    public function deleter()
    {
        return $this->morphTo();
    }

    /* ================================================================
     |  Accessors
     ================================================================ */

    protected function formatDate(?string $value, $createdAt = null): string
    {
        if ($createdAt != null) {
            return $value != $createdAt ? Carbon::parse($value)->format('d M, Y h:i A') : 'N/A';
        }
        return $value ? Carbon::parse($value)->format('d M, Y h:i A') : 'N/A';
    }

    public function getCreatedAtHumanAttribute(): string
    {
        return optional($this->created_at)?->diffForHumans() ?? 'N/A';
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return optional($this->updated_at)?->diffForHumans() ?? 'N/A';
    }

    public function getDeletedAtHumanAttribute(): ?string
    {
        return optional($this->deleted_at)?->diffForHumans();
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->formatDate($this->created_at);
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return $this->formatDate($this->updated_at, $this->created_at);
    }

    public function getDeletedAtFormattedAttribute(): string
    {
        return $this->formatDate($this->deleted_at);
    }
}
