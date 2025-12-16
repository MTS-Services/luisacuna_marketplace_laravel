<?php
 
namespace App\Models;

use App\Enums\SellerExperience;
use App\Enums\SellerKycStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Dom\DocumentType;
use OwenIt\Auditing\Contracts\Auditable;
 
class SellerKyc extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //
 
    protected $fillable = [
        'sort_order',
        'seller_id',
        'service_category_id',
        //Individual Information
        'first_name',
        'last_name',
        'dob',
        'nationality',
        'address',
        'city',
        'country_id',
        'postal_code',

        'document_type',
        'front_image',
        'selfie_image',
        'seller_experience',

        'company_name',
        'company_address',
        'company_city',
        'company_country_id',
        'company_postal_code',
        'company_license_number',
        'company_tax_number',

        'status',

        'created_at',
        'deleted-at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by',

 
      //here AuditColumns 
    ];
 
    protected $hidden = [
        //
    ];
 
    protected $casts = [
        'status' => SellerKycStatus::class,
        'document_type' => DocumentType::class,
        'seller_experience' => SellerExperience::class

    ];
 
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
     //

     public function seller()
     {
         return $this->belongsTo(User::class, 'seller_id', 'id');
     }

    public function categories()
    {
        return $this->hasMany(KycCategory::class, 'seller_kyc_id');
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