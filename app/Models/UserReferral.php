<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReferral extends BaseModel
{
       protected $fillable = [
        'sort_order',
        'user_id',
        'referral_code',
        'referred_by',
        'referral_earnings',
        'referrer_id',
        'referral_setting_id',
        'currency_id',

        'created_type',
        'updated_type',
        'deleted_type',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $casts = [
        'referral_earnings' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
    public function referrerReferralSetting()
    {
        return $this->belongsTo(ReferralSetting::class, 'referrer_id');
    }
    public function referrer_Id()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
    public function currency_id()
    {
        return $this->belongsTo(Currency::class,'currency_id', 'id');
    }


}
