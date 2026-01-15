<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use App\Enums\AchievementStatus;
use App\Traits\HasTranslations;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Achievement extends AuditBaseModel implements Auditable
{
    use Searchable, AuditableTrait, HasTranslations;

    protected $fillable = [
        'sort_order',
        'icon',
        'title',
        'description',
        'achievement_type_id',
        'target_value',
        'point_reward',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',

        //here AuditColumns 


    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'status' => AchievementStatus::class,
        'restored_at' => 'datetime',
    ];

    /* ================================================================
     |  Translation Configuration
     ================================================================ */

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['title', 'description'],
            'relation' => 'achievementTranslations',
            'model' => AchievementsTranslation::class,
            'foreign_key' => 'achievement_id',
            'field_mapping' => [
                'title' => 'title',
                'description' => 'description',
            ],
        ];
    }

    public function translatedTitle($languageIdOrLocale): string
    {
        return $this->getTranslated('title', $languageIdOrLocale) ?? $this->title;
    }
    public function translatedDescription($languageIdOrLocale): string
    {
        return $this->getTranslated('description', $languageIdOrLocale) ?? $this->description;
    }
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id', 'id');
    }

    public function achievementType()
    {
        return $this->belongsTo(AchievementType::class, 'achievement_type_id', 'id');
    }

    public function achievementTranslations()
    {

        return $this->hasMany(AchievementsTranslation::class, 'achievement_id', 'id');
    }
    public function progress()
    {
        return $this->hasMany(UserAchievementProgress::class, 'achievement_id', 'id');
    }

    public function userProgress($userId){
        return $this?->progress()?->where('user_id', $userId)->first();
    }
    public function currentProgress(){
       return $this?->userProgress(user()->id)?->current_progress ?? 0;
    }



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    /* ================================================================
     |  Query Scopes
     ================================================================ */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', AchievementStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', AchievementStatus::INACTIVE);
    }
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['title'] ?? null,
                fn($q, $title) =>
                $q->where('title', 'like', "%{$title}%")
            )
            ->when(
                $filters['description'] ?? null,
                fn($q, $description) =>
                $q->where('description', 'like', "%{$description}%")
            )
            ->when(
                $filters['rank_id'] ?? null,
                fn($q, $rank_id) =>
                $q->where('rank_id', 'like', "%{$rank_id}%")
            )
            ->when(
                $filters['category_id'] ?? null,
                fn($q, $category_id) =>
                $q->where('category_id', 'like', "%{$category_id}%")
            );
    }


    /* ================================================================
     |  Query Scopes
     ================================================================ */


    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'title', 'description', 'target_value', 'point_reward', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'target_value' => (int) $this->target_value,
            'point_reward' => (int) $this->point_reward,
            'status' => $this->status,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            // 'status_label',
            // 'status_color',
        ]);
    }
}
