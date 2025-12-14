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
        'first_name',
        'last_name',
        'dob',
        'nationality',
        'address',
        'city',
        'country',
        'postal_code',
        'document_type',
        'front_image',
        'back_image',
        'seller_experience',
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

     public function service_category()
     {
         return $this->belongsTo(Category::class, 'service_category_id', 'id');
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