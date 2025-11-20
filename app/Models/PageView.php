<?php

namespace App\Models;

use App\Models\AuditBaseModel;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class PageView extends AuditBaseModel implements Auditable
{
    use   AuditableTrait, Searchable;
    //

    protected $fillable = [
        'sort_order',
        'viewable_type',
        'viewable_id',
        'viewer_type',
        'viewer_id',
        'ip_address',
        'user_agent',
        'referrer',
        'created_at',

        //here AuditColumns 

        'creater_type',
        'updater_type',
        'deleter_type',
        'restorer_type',


        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['ip_address'] ?? null,
                fn($q, $ip) => $q->where('ip_address', 'like', "%{$ip}%")
            )
            ->when(
                $filters['viewable_type'] ?? null,
                fn($q, $type) => $q->where('viewable_type', $type)
            )
            ->when(
                $filters['viewer_type'] ?? null,
                fn($q, $type) => $q->where('viewer_type', $type)
            );
    }


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start Query Scopes
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */



    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'viewable_type', 'viewer_type', 'ip_address'])]
    public function toSearchableArray(): array
    {
        return [
            'viewable_type' => $this->viewable_type,
            'viewer_type' => $this->viewer_type,
            'ip_address' => $this->ip_address,
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
            //
        ]);
    }
}
