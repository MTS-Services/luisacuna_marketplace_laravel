<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class SellerProfileTranslation extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'seller_profile_id',
        'language_id',
        'shop_name',
        'shop_description',
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'seller_profile_id' => 'integer',
        'language_id' => 'integer',
        'sort_order' => 'integer',
    ];

    /* ================================================================
     |  Relationships
     ================================================================ */

    public function sellerProfile()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_profile_id', 'id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    /* ================================================================
     |  Scopes
     ================================================================ */

    public function scopeForLanguage($query, $languageIdOrLocale)
    {
        if (is_numeric($languageIdOrLocale)) {
            return $query->where('language_id', $languageIdOrLocale);
        }

        return $query->whereHas('language', function ($q) use ($languageIdOrLocale) {
            $q->where('locale', $languageIdOrLocale);
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
