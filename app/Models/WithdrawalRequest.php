<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class WithdrawalRequest extends AuditBaseModel implements Auditable
{
    use AuditableTrait;
    //

    protected $fillable = [
        'user_id',
        'withdrawal_method_id',
        'amount',
        'fee_amount',
        'tax_amount',
        'final_amount',
        'currency_id',
        'sort_order',
        'verified_at',
        'last_used_at',
        'note',

        'updated_by',
        'created_by',

        // here AuditColumns
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function withdrawalMethod(): BelongsTo
    {
        return $this->belongsTo(WithdrawalMethod::class, 'withdrawal_method_id');
    }

    public function currentStatusHistory(): HasOne
    {
        return $this->hasOne(WithdrawalStatusHistory::class, 'withdrawal_request_id', 'id')->latestOfMany();
    }

    public function withdrawalStatusHistory(): HasMany
    {
        return $this->hasMany(WithdrawalStatusHistory::class, 'withdrawal_request_id', 'id');
    }

    public function getCurrentStatusAttribute(): ?string
    {
        return $this->currentStatusHistory?->to_status;
    }

    public function getCurrentStatusLabelAttribute(): string
    {
        $status = (string) ($this->current_status ?? '');

        return match ($status) {
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'canceled' => 'Canceled',
            'rejected' => 'Rejected',
            default => $status !== '' ? ucfirst($status) : 'N/A',
        };
    }

    public function getCurrentStatusColorAttribute(): string
    {
        $status = (string) ($this->current_status ?? '');

        return match ($status) {
            'pending' => 'warning',
            'accepted' => 'success',
            'canceled' => 'danger',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['search'] ?? null,
                function (Builder $q, $search) {
                    $q->where(function (Builder $qq) use ($search) {
                        $qq->whereHas('user', function (Builder $uq) use ($search) {
                            $uq->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                            ->orWhereHas('withdrawalMethod', function (Builder $mq) use ($search) {
                                $mq->where('name', 'like', "%{$search}%")
                                    ->orWhere('code', 'like', "%{$search}%");
                            })
                            ->orWhere('id', 'like', "%{$search}%");
                    });
                }
            );
    }

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
