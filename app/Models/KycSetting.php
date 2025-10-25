<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\KycSettingType;
use App\Enums\KycSettingStatus;

class KycSetting extends BaseModel
{
    //

    protected $fillable = [
        'sort_order',
        'type',
        'status',
        'version',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => KycSettingType::class,
        'status' => KycSettingStatus::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function CountryKycSettings()
    {
        return $this->hasMany(CountryKycSetting::class);
    }
    public function submittedKyc()
    {
        return $this->hasMany(SubmittedKyc::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', KycSettingStatus::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', KycSettingStatus::INACTIVE);
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

    public function isActive(): bool
    {
        return $this->status === KycSettingStatus::ACTIVE;
    }
    public function activate(): void
    {
        $this->update(['status' => KycSettingStatus::ACTIVE]);
    }
    public function deactivate(): void
    {
        $this->update(['status' => KycSettingStatus::INACTIVE]);
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
