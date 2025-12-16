<?php

namespace App\Models;

use App\Enums\SellerLevel;
use App\Models\AuditBaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use OwenIt\Auditing\Contracts\Auditable;

class SellerProfile extends AuditBaseModel implements Auditable
{
    use AuditableTrait, HasTranslations;

    protected $fillable = [
        'sort_order',
        'user_id',
        'country_id',
        'account_type',
        'first_name',
        'last_name',
        'date_of_birth',
        'nationality',
        'street_address',
        'city',
        'postal_code',
        'is_experienced_seller',
        'identification',
        'selfie_image',
        'company_documents',
        'company_name',
        'company_license_number',
        'company_tax_number',
        'id_verified',
        'id_verified_at',
        'seller_verified',
        'seller_verified_at',
        'seller_level',
        'commission_rate',
        'minimum_payout',
        'deleted_at',
        'updated_at',
        'restored_at',

    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'seller_verified' => 'boolean',
        'seller_verified_at' => 'datetime',
        'commission_rate' => 'decimal:2',
        'minimum_payout' => 'decimal:2',
        'seller_level' => SellerLevel::class,
    ];

    /* ================================================================
     |  Translation Configuration
     ================================================================ */

    /**
     * Define translation configuration for this model
     */
    protected function getTranslationConfig(): array
    {
        return [
            // Fields to translate from main model
            'fields' => ['shop_name', 'shop_description'],

            // Relationship name
            'relation' => 'sellerProfileTranslations',

            // Translation model class
            'model' => SellerProfileTranslation::class,

            // Foreign key in translation table
            'foreign_key' => 'seller_profile_id',

            // Map model fields to translation table fields
            'field_mapping' => [
                'shop_name' => 'shop_name',           // ✅ FIXED: was 'name' => 'name'
                'shop_description' => 'shop_description', // ✅ ADDED
            ],
        ];
    }

    /* ================================================================
     |  Relationships
     ================================================================ */

    public function sellerProfileTranslations(): HasMany
    {
        return $this->hasMany(SellerProfileTranslation::class, 'seller_profile_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


  public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'seller_categories',
            'seller_profile_id',
            'category_id'
        )->withTimestamps();
    }
    /* ================================================================
     |  Translation Helper Methods (Convenience)
     ================================================================ */

    public function getShopNameTranslated($languageIdOrLocale): ?string
    {
        return $this->getTranslated('shop_name', $languageIdOrLocale) ?? $this->shop_name; // ✅ ADDED fallback
    }

    public function getShopDescriptionTranslated($languageIdOrLocale): ?string
    {
        return $this->getTranslated('shop_description', $languageIdOrLocale) ?? $this->shop_description; // ✅ ADDED fallback
    }

    public function getAllShopNameTranslations(): array
    {
        return $this->getAllTranslationsFor('shop_name');
    }

    public function getAllShopDescriptionTranslations(): array
    {
        return $this->getAllTranslationsFor('shop_description');
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('seller_verified', true);
    }

    public function scopeUnverified(Builder $query): Builder
    {
        return $query->where('seller_verified', false);
    }

    public function scopeByLevel(Builder $query, SellerLevel $level): Builder
    {
        return $query->where('seller_level', $level);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['verified'] ?? null,
                fn($q, $verified) =>
                $verified ? $q->verified() : $q->unverified()
            )
            ->when(
                $filters['level'] ?? null,
                fn($q, $level) =>
                $q->where('seller_level', $level)
            )
            ->when(
                $filters['shop_name'] ?? null,
                fn($q, $name) =>
                $q->where('shop_name', 'like', "%{$name}%")
            );
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('shop_name', 'like', "%{$search}%")
                ->orWhere('shop_description', 'like', "%{$search}%");
        });
    }

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'shop_name'])]
    public function toSearchableArray(): array
    {
        return [
            'shop_name' => $this->shop_name,
            'shop_description' => $this->shop_description,
            'seller_level' => $this->seller_level->value,
            'seller_verified' => $this->seller_verified,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }


    /* ================================================================
     |  Accessors & Mutators
     ================================================================ */

    public function getIsVerifiedAttribute(): bool
    {
        return $this->seller_verified;
    }
    public function getSellerLevelLabelAttribute(): string
    {
        return $this->seller_level->label();
    }

    public function getSellerLevelColorAttribute(): string
    {
        return $this->seller_level->color();
    }

    /* ================================================================
     |  Methods
     ================================================================ */

    public function verify(): void
    {
        $this->update([
            'seller_verified' => true,
            'seller_verified_at' => now(),
        ]);
    }

    public function unverify(): void
    {
        $this->update([
            'seller_verified' => false,
            'seller_verified_at' => null,
        ]);
    }

    public function isVerified(): bool
    {
        return $this->seller_verified;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            'seller_level_label',
            'seller_level_color',
            'is_verified'
        ]);
    }
}
