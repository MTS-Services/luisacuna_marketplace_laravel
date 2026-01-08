<?php

namespace App\Models;

use App\Enums\FeedbackType;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Feedback extends AuditBaseModel implements Auditable
{
    use   AuditableTrait, HasTranslations;
    //

    protected $fillable = [
        'id',
        'sort_order',
        'author_id',
        'target_user_id',
        'order_id',
        'type',
        'message',
        'rating',

        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => FeedbackType::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function feedbackTranslations(): HasMany
    {
        return $this->hasMany(FeedbackTranslation::class, 'feedback_id', 'id');
    }

        /* =========================================
            Translation Configuration
     ========================================= */

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['message'],
            'relation' => 'feedbackTranslations',
            'model' => FeedbackTranslation::class,
            'foreign_key' => 'feedback_id',
            'field_mapping' => [
                'message' => 'message',
            ]
        ];
    }
 

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', $type);
        });
        $query->when($filters['target_user_id'] ?? null, function ($query, $userId) {
            $query->where('target_user_id', $userId);
        });
        $query->when($filters['author_id'] ?? null, function ($query, $userId) {
            $query->where('author_id', $userId);
        });

        return $query;
    }
}
