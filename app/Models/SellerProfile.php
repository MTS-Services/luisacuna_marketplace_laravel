<?php

namespace App\Models;

use App\Enums\SellerLevel;
use Illuminate\Database\Eloquent\Model;
use App\Models\AuditBaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class SellerProfile extends AuditBaseModel implements Auditable
{
    use  AuditableTrait;
    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'seller_verified',
        'seller_verified_at',
        'seller_level',
        'commission_rate',
        'minimum_payout',


        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];

    protected $casts = [
        'seller_verified' => 'boolean',
        'seller_verified_at' => 'datetime',
        'commission_rate' => 'decimal:2',
        'minimum_payout' => 'decimal:2',
        'seller_level' => SellerLevel::class,
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function getSellerLevelLabelAttribute(): string
    {
        return $this->seller_level->label();
    }

    public function getSellerLevelColorAttribute(): string
    {
        return $this->seller_level->color();
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            'seller_level_label',
            'seller_level_color',
        ]);
    }
}
