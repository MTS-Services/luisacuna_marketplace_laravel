<?php

namespace App\Models;

use App\Enums\CmsType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Cms extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
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

   public function gameTranslations(): HasMany
    {
        return $this->hasMany(CmsTranslation::class, 'cms_id', 'id');
    }


    /* =========================================
            Translation Configuration
     ========================================= */

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['content'],
            'relation' => 'gameTranslations',
            'model' => CmsTranslation::class,
            'foreign_key' => 'cms_id',
            'field_mapping' => [
                'content' => 'content',
            ]
        ];
    }
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
