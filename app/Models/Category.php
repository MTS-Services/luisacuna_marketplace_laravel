<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Category extends AuditBaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'icon',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'status' => CategoryStatus::class
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function categoryLanguages(): HasMany
    {
        return $this->hasMany(CategoryLanguage::class, 'category_id', 'id');
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'category_id', 'id');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Translation Helper Methods
     ================================================================ */

    /**
     * Get translated name for a specific language
     * 
     * @param int|string $languageIdOrLocale Language ID or locale code (e.g., 'es', 'fr')
     * @return string Translated name or original name if not found
     */
    public function getTranslatedName($languageIdOrLocale): string
    {
        if (is_numeric($languageIdOrLocale)) {
            // Search by language ID
            $translation = $this->categoryLanguages()
                ->where('language_id', $languageIdOrLocale)
                ->first();
        } else {
            // Search by locale code
            $translation = $this->categoryLanguages()
                ->whereHas('language', function ($query) use ($languageIdOrLocale) {
                    $query->where('locale', $languageIdOrLocale);
                })
                ->first();
        }

        return $translation?->name ?? $this->name;
    }

    /**
     * Get all translations as an array
     * 
     * @return array ['es' => 'Deportes', 'fr' => 'Sports', ...]
     */
    public function getAllTranslations(): array
    {
        return $this->categoryLanguages()
            ->with('language')
            ->get()
            ->mapWithKeys(function ($translation) {
                return [$translation->language->locale => $translation->name];
            })
            ->toArray();
    }

    /**
     * Check if translation exists for a specific language
     */
    public function hasTranslation($languageIdOrLocale): bool
    {
        if (is_numeric($languageIdOrLocale)) {
            return $this->categoryLanguages()
                ->where('language_id', $languageIdOrLocale)
                ->exists();
        }

        return $this->categoryLanguages()
            ->whereHas('language', function ($query) use ($languageIdOrLocale) {
                $query->where('locale', $languageIdOrLocale);
            })
            ->exists();
    }

    /**
     * Get translation progress (percentage)
     */
    public function getTranslationProgress(): array
    {
        $totalLanguages = \App\Models\Language::where('status', \App\Enums\LanguageStatus::ACTIVE)->count();
        $translatedCount = $this->categoryLanguages()->count();

        return [
            'total' => $totalLanguages,
            'translated' => $translatedCount,
            'percentage' => $totalLanguages > 0 ? round(($translatedCount / $totalLanguages) * 100, 2) : 0,
        ];
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) => $q->where('status', $status)
            )
            ->when(
                $filters['name'] ?? null,
                fn($q, $name) => $q->where('name', 'like', "%{$name}%")
            );
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('meta_description', 'like', "%{$search}%");
        });
    }

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name', 'meta_title'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'meta_title' => $this->meta_title,
            'status' => $this->status,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
