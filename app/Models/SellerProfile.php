<?php

namespace App\Models;

use App\Enums\SellerLevel;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class SellerProfile extends BaseModel
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'seller_verified',
        'seller_verified_at',
        'seller_level',
        'commission_rate',
        'minimum_payout',
    ];

    protected $casts = [
        'seller_level' => SellerLevel::class,
        'seller_verified' => 'boolean',
        'seller_verified_at' => 'datetime',
        'commission_rate' => 'decimal:2',
        'minimum_payout' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
