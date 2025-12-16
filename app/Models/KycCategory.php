<?php
 
namespace App\Models;
 
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
 
class KycCategory extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    //
 
    protected $fillable = [
        'sort_order',
        'service_category_id',
        'seller_kyc_id',
 
      //here AuditColumns 
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
 
    public function categories()
    {
        return $this->belongsTo(Category::class, 'service_category_id', 'id');
    }

    public function kycs()
    {
        return $this->belongsTo(SellerKyc::class, 'seller_kyc_id', 'id');
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