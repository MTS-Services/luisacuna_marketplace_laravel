<?php
 
namespace App\Models;
 
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Faker\Provider\Base;
use OwenIt\Auditing\Contracts\Auditable;
 
class FaqTranslation extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //
 
    protected $fillable = [
        'sort_order',
        'faq_id',
        'language_id',
        'question',
        'answer',
      //here AuditColumns 
    ];
 
    protected $hidden = [
        //
    ];
 
    protected $casts = [
        //
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faq_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
 
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
     //
 
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