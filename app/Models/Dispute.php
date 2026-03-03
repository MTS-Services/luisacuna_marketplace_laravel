<?php

namespace App\Models;

use App\Enums\DisputeStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Dispute extends AuditBaseModel implements Auditable
{
    use AuditableTrait, Searchable;

    protected $fillable = [
        'sort_order',
        'order_id',
        'buyer_id',
        'vendor_id',
        'status',
        'reason_category',
        'description',
        'resolved_at',
    ];

    protected $casts = [
        'status' => DisputeStatus::class,
        'resolved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DisputeMessage::class, 'dispute_id', 'id')->orderBy('created_at');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(DisputeAttachment::class, 'dispute_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeForBuyer(Builder $query, User $user): Builder
    {
        return $query->where('buyer_id', $user->id);
    }

    public function scopeForVendor(Builder $query, User $user): Builder
    {
        return $query->where('vendor_id', $user->id);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn('status', [
            DisputeStatus::PENDING_VENDOR,
            DisputeStatus::ESCALATED,
        ]);
    }

    public function scopeClosed(Builder $query): Builder
    {
        return $query->whereIn('status', [
            DisputeStatus::RESOLVED_REFUND,
            DisputeStatus::RESOLVED_CLOSED,
        ]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}

