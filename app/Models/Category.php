<?php

namespace App\Models;

use App\Enums\CategoryLayout;
use App\Enums\CategoryStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class Category extends AuditBaseModel implements Auditable
{
    use AuditableTrait, HasTranslations;

    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'icon',
        'status',
        'layout',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $hidden = ['id'];

    protected $casts = [
        'status' => CategoryStatus::class,
        'layout' => CategoryLayout::class
    ];

    /* ================================================================
     |  Translation Configuration
     ================================================================ */

    /**
     * Define translation configuration for this model
     */
    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['name'],
            'relation' => 'categoryTranslations',
            'model' => CategoryTranslation::class,
            'foreign_key' => 'category_id',
            'field_mapping' => [
                'name' => 'name',
            ],
        ];
    }

    public function translatedName($languageIdOrLocale): string
    {
        return $this->getTranslated('name', $languageIdOrLocale) ?? $this->name;
    }
    /* ================================================================
     |  Relationships
     ================================================================ */

    public function categoryTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_categories')
            ->withTimestamps();
    }

    public function gameCategories(): HasMany
    {
        return $this->hasMany(GameCategory::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function userProduct($userId)
    {
        return $this->products()->where('user_id', $userId)->count();
    }


    /* ================================================================
     |  Translation Helper Methods (Convenience)
     ================================================================ */

    public function getTranslatedName($languageIdOrLocale): string
    {
        return $this->getTranslated('name', $languageIdOrLocale) ?? $this->name;
    }

    public function getAllTranslatedNames(): array
    {
        return $this->getAllTranslationsFor('name');
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
    public function scopeListGrid(Builder $query): Builder
    {
        return $query->where('layout', CategoryLayout::LIST_GRID);
    }

    public function scopeNotAssignedToGame($query, int $gameId)
    {
        return $query->whereDoesntHave('games', function ($q) use ($gameId) {
            $q->where('games.id', $gameId);
        });
    }

    public function scopeGroupGiftCard(Builder $query): Builder
    {
        return $query->where('layout', CategoryLayout::GROUP_GIFT_CARD);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['layout'] ?? null, fn($q, $layout) => $q->where('layout', $layout))
            ->when($filters['name'] ?? null, fn($q, $name) => $q->where('name', 'like', "%{$name}%"));
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('layout', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        });
    }

    #[SearchUsingPrefix(['name', 'status', 'layout'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'layout' => $this->layout,
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
            'games_count',
        ]);
    }

    public function getGamesCountAttribute(): int
    {
        return $this->games()->count();
    }
}
