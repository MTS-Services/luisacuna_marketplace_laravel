<?php
 
namespace App\Models;

use App\Enums\GameFeatureStatus;
use App\Models\AuditBaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class GameFeature extends AuditBaseModel implements Auditable
{
    use   AuditableTrait;
    /** @use HasFactory<\Database\Factories\GameServerFactory> */
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'name',
        'status',
        'icon',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
        //here AuditColumns
    ];

    protected $hidden = [
        //
        'id',
    ];

    protected $casts = [
        //
        'status' => GameFeatureStatus::class,
        'restored_at' => 'datetime',
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

     public function games()
    {
        return $this->belongsToMany(
            Game::class,
            'game_servers',
            'server_id',
            'game_id'
        );
    }

     /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', GameFeatureStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', GameFeatureStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'name', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
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
            //
        ]);
    }
}