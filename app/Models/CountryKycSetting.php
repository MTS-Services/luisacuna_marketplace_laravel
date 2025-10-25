<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\CountryKycSettingType;
use App\Enums\CountryKycSettingStatus;

class CountryKycSetting extends BaseModel
{
    //

    protected $fillable = [
        'sort_order',
        'kyc_setting_id',
        'country_id',
        'type',
        'status',
        'version',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => CountryKycSettingType::class,
        'status' => CountryKycSettingStatus::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function kycSetting()
    {
        return $this->belongsTo(KycSetting::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function kycFormSections()
    {
        return $this->hasMany(KycFormSection::class);
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
        return $query->where('status', CountryKycSettingStatus::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', CountryKycSettingStatus::INACTIVE);
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

    public function getStatusAttribute(): string
    {
        return $this->status->label();
    }
    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }
    public function getTypeAttribute(): string
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
        return $this->status === CountryKycSettingStatus::ACTIVE;
    }
    public function activate(): void
    {
        $this->update(['status' => CountryKycSettingStatus::ACTIVE]);
    }
    public function deactivate(): void
    {
        $this->update(['status' => CountryKycSettingStatus::INACTIVE]);
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
