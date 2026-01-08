<?php
 
namespace App\Models;

use App\Enums\HeroStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use OwenIt\Auditing\Contracts\Auditable;
 
class Hero extends BaseModel implements Auditable
{
    use   AuditableTrait, HasTranslations;
    //
 
    protected $fillable = [
        'sort_order',
        'title',
        'content',
        'action_title',
        'action_url',
        'image',
        'mobile_image',
        'target',
        'status',
 
      //here AuditColumns 
    ];
 
    protected $hidden = [
        //
    ];
 
    protected $casts = [
        'status' => HeroStatus::class,
    ];
 
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
     //


     public function heroTranslations(): HasMany
     {
         return $this->hasMany(HeroTranslation::class, 'hero_id', 'id');
     }


    //  Game translation Config
    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['title', 'content'],
            'relation' => 'heroTranslations',
            'model' => HeroTranslation::class,
            'foreign_key' => 'hero_id',
            'field_mapping' => [
                'title' => 'title',
                'content' => 'content',
            ]
        ];
    }

     public function scopeFilter(Builder $query, $filters): Builder
     {
        if($filters['status'] ?? null){
            $query->where('status', $filters['status']);
        }
         return $query;   
     }
     /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
    #[SearchUsingPrefix(['title', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->title,
            'status' => $this->status,
        ];
    }




    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', HeroStatus::ACTIVE);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }

 
 
}