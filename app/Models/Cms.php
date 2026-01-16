<?php

namespace App\Models;

use App\Enums\CmsType;
use App\Enums\HelpfulType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Cms extends AuditBaseModel implements Auditable
{
    use   AuditableTrait, HasTranslations;
    //

    protected $fillable = [
        'sort_order',
        'type',
        'content',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => CmsType::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    public function cmsTranslations(): HasMany
    {
        return $this->hasMany(CmsTranslation::class, 'cms_id', 'id');
    }

    public function helpfuls(): HasMany
    {
        return $this->hasMany(Helpful::class, 'cms_id', 'id');
    }

    public function latestHelpful(): HasOne
    {
        return $this->hasOne(Helpful::class, 'cms_id', 'id')->latestOfMany();
    }
    /* =========================================
            Translation Configuration
     ========================================= */

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['content'],
            'relation' => 'cmsTranslations',
            'model' => CmsTranslation::class,
            'foreign_key' => 'cms_id',
            'field_mapping' => [
                'content' => 'content',
            ]
        ];
    }
    public function translatedContent($languageIdOrLocale): string
    {
        return $this->getTranslated('content', $languageIdOrLocale) ?? $this->content;
    }
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
    public function getIsUsefulAttribute(): ?bool
    {
        if (!$this->latestHelpful) {
            return null;
        }

        return $this->latestHelpful->type === \App\Enums\HelpfulType::POSITIVE->value;
    }
    public function getHelpfulCooldownActiveAttribute(): bool
    {
        if (!$this->latestHelpful) {
            return false;
        }

        return $this->latestHelpful->created_at->addHours(24)->isFuture();
    }


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'helpful_cooldown_active',
            'is_useful',
        ]);
    }
}
