<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends AuditBaseModel implements Auditable
{
    use AuditableTrait, SoftDeletes;

    protected $fillable = [
        'sort_order',
        'source_id',
        'source_type',
        'fcm_token',
        'device_type',
        'device_name',
        'device_model',
        'os_version',
        'app_version',
        'session_id',
        'ip_address',
        'user_agent',
        'is_active',
        'last_used_at',
        'logged_out_at',
        'device_fingerprint',
    ];

    protected $hidden = [
        'fcm_token',
        'device_fingerprint',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /**
     * Get the owning source model (User or Admin).
     */
    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeForUser($query, $sourceType, $sourceId)
    {
        return $query->where('source_type', $sourceType)
            ->where('source_id', $sourceId);
    }

    public function scopeBySession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Accessors
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function getDeviceInfoAttribute(): string
    {
        $parts = array_filter([
            $this->device_name,
            $this->device_model,
            $this->os_version
        ]);

        return implode(' - ', $parts) ?: 'Unknown Device';
    }

    public function getIsCurrentDeviceAttribute(): bool
    {
        return $this->session_id === session()->getId();
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Methods
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /**
     * Mark device as inactive/logged out.
     */
    public function logout(): bool
    {
        return $this->update([
            'is_active' => false,
            'logged_out_at' => now(),
        ]);
    }

    /**
     * Update last used timestamp.
     */
    public function updateLastUsed(): bool
    {
        return $this->update(['last_used_at' => now()]);
    }

    /**
     * Check if device is stale (inactive for too long).
     */
    public function isStale(int $days = 30): bool
    {
        if (!$this->last_used_at) {
            return false;
        }

        return $this->last_used_at->diffInDays(now()) > $days;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'device_info',
            'is_current_device',
        ]);
    }
}
