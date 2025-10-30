<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\CountryKycSettingStatus;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class KycFormSection extends BaseModel implements Auditable
{
    use  AuditableTrait;

    protected $fillable = [
        'sort_order',
        'kyc_setting_id',
        'kyc_setting_type',
        'title',
        'description',

        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
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

    public function kyc_setting()
    {
        return $this->belongsTo(CountryKycSetting::class);
    }
    public function kyc_form_fields()
    {
        return $this->hasMany(KycFormField::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */



    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }



    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */




    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */





    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);
    //     $this->appends = array_merge(parent::getAppends(), [
    //         //
    //     ]);
    // }
}
