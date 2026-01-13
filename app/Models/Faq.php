<?php

namespace App\Models;

use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Faq extends AuditBaseModel implements Auditable
{




    use AuditableTrait, Searchable, HasTranslations;

    protected $table = 'faq';

    protected $fillable = [
        'sort_order',
        'type',
        'status',
        'question',
        'answer',
    ];

    protected $casts = [
        'status' => FaqStatus::class,
        'type' => FaqType::class

    ];

    /**
     * Avoid hiding "id" unless absolutely necessary for API response.
     */
    protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function faqTranslations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class, 'cms_id', 'id');
    }


    /* =========================================
            Translation Configuration
     ========================================= */

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['question', 'answer'],
            'relation' => 'faqTranslations',
            'model' => FaqTranslation::class,
            'foreign_key' => 'faq_id',
            'field_mapping' => [
                'question' => 'question',
                'answer' => 'answer',
            ]
        ];
    }

    public function translatedQuestion($languageIdOrLocale): string
    {
        return $this->getTranslated('question', $languageIdOrLocale) ?? $this->question;
    }

    public function translatedAnswer($languageIdOrLocale): string
    {
        return $this->getTranslated('answer', $languageIdOrLocale) ?? $this->answer;
    }



    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', FaqStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', FaqStatus::INACTIVE);
    }
    public function scopeBuyer(Builder $query): Builder
    {
        return $query->where('status', FaqType::BUYER);
    }

    public function scopeSeller(Builder $query): Builder
    {
        return $query->where('status', FaqType::SELLER);
    }


    /*
    |--------------------------------------------------------------------------
    | Scout Search Configuration
    |--------------------------------------------------------------------------
    */

    #[SearchUsingPrefix(['id', 'question'])]
    public function toSearchableArray(): array
    {
        return [
            'question' => $this->question,
            'answer'   => $this->answer,
            'type'     => $this->type->value ?? null,
            'status'     => $this->status->value ?? null
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->deleted_at === null;
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
                $filters['type'] ?? null,
                fn($q, $type) =>
                $q->where('type', $type)
            );
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            // Add custom accessors if needed
        ]);
    }
}
