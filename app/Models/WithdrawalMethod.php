<?php

namespace App\Models;

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

class WithdrawalMethod extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [

        'sort_order',
        'name',
        'code',
        'status',
        'description',
        'icon',
        'min_amount',
        'max_amount',
        'processing_time',
        'fee_type',
        'fee_amount',
        'fee_percentage',
        'required_fields',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',

        'created_at',
        'updated_at',
        'deleted_at',
        'restored_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'status' => ActiveInactiveEnum::class,
        'fee_type' => WithdrawalFeeType::class,
        'required_fields' => 'array',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['fee_type'] ?? null,
                fn($q, $feeType) =>
                $q->where('fee_type', $feeType)
            )
            ->when(
                $filters['name'] ?? null,
                fn($q, $name) =>
                $q->where('name', 'like', "%{$name}%")
            );
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
