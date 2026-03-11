<?php

namespace App\Models;

use App\Enums\SanctionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSanction extends Model
{
    protected $fillable = [
        'sort_order',
        'user_id',
        'admin_id',
        'type',
        'reason',
        'duration',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'type' => SanctionType::class,
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function (Builder $q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeOfType(Builder $query, SanctionType $type): Builder
    {
        return $query->where('type', $type->value);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
