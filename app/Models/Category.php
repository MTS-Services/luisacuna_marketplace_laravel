<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

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
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $hidden = ['id'];

    protected $casts = [
        'status' => CategoryStatus::class
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

    /* ================================================================
     |  Relationships
     ================================================================ */

    public function categoryTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class,'game_categories','category_id','game_id' );
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id', 'id');
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

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['name'] ?? null, fn($q, $name) => $q->where('name', 'like', "%{$name}%"));
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('meta_description', 'like', "%{$search}%");
        });
    }

    #[SearchUsingPrefix(['name', 'meta_title'])]
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


    public function game(){

        return $this->belongsToMany(Game::class, 'game_categories', 'category_id', 'game_id')->get();
    }
}
