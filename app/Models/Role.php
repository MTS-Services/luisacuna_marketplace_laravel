<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends SpatieRole implements Auditable
{
    use AuditableTrait, SoftDeletes, HasFactory;


    protected $fillable = [
        'sort_order',
        "name",
        "guard_name",

        "created_by",
        "updated_by",
        "deleted_by",
        "restored_by",
        "restored_at",
    ];

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $appends = [

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',
        'restored_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
        'restored_at_formatted',
    ];
    /* ================================================================
        * *** Relations ***
        ================================================================ */

    public function creater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select(['name', 'id', 'status']);
    }

    public function updater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->select(['name', 'id', 'status']);
    }

    public function deleter_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'deleted_by', 'id')->select(['name', 'id', 'status']);
    }
    public function restorer_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'restored_by', 'id')->select(['name', 'id', 'status']);
    }

    /* ================================================================
     * *** Accessors ***
     ================================================================ */

    public function getCreatedAtHumanAttribute(): string
    {
        return dateTimeHumanFormat($this->attributes['created_at']);
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return dateTimeHumanFormat($this->attributes['updated_at'], $this->attributes['created_at']);
    }

    public function getDeletedAtHumanAttribute(): ?string
    {
        return dateTimeHumanFormat($this->attributes['deleted_at']);
    }
    public function getRestoredAtHumanAttribute(): ?string
    {
        return dateTimeHumanFormat($this->attributes['restored_at']);
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['created_at']);
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['updated_at'], $this->attributes['created_at']);
    }

    public function getDeletedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['deleted_at']);
    }
    public function getRestoredAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['restored_at']);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id', 'id');
    }

}
