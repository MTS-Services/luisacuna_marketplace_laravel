<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\SubmittedKycStatus;

class SubmittedKyc extends BaseModel
{
    //

    protected $fillable = [
        'sort_order',
        'kyc_setting_id',
        'ckyc_setting_id',
        'version',
        'type',
        'status',
        'submitted_data',
        'note',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => SubmittedKycStatus::class,
        'status' => SubmittedKycStatus::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function kycSetting()
    {
        return $this->belongsTo(KycSetting::class);
    }
    public function CountrykycSetting()
    {
        return $this->belongsTo(CountryKycSetting::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */




    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApproved($query)
    {
        return $query->where('status', SubmittedKycStatus::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', SubmittedKycStatus::PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', SubmittedKycStatus::REJECTED);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('version', 'like', "%{$search}%");
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status));
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type));

        return $query;
    }



    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }
    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }
    public function getTypeLabelAttribute(): string
    {
        return $this->type->label();
    }
    public function getTypeColorAttribute(): string
    {
        return $this->type->color();
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */


    public function isApproved(): bool
    {
        return $this->status === SubmittedKycStatus::APPROVED;
    }
    public function approvate(): void
    {
        $this->update(['status' => SubmittedKycStatus::APPROVED]);
    }
    public function pending(): void
    {
        $this->update(['status' => SubmittedKycStatus::PENDING]);
    }
    public function reject(): void
    {
        $this->update(['status' => SubmittedKycStatus::REJECTED]);
    }


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'type_label',
            'type_color',
        ]);
    }
}
