<?php
 
namespace App\Models;

use App\Enums\GameServerStatus;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use OwenIt\Auditing\Contracts\Auditable;
 
class GameServer extends BaseModel implements Auditable
{
    use   AuditableTrait;
    /** @use HasFactory<\Database\Factories\GameServerFactory> */
    use HasFactory;
 
    protected $fillable = [
        'sort_order',
        'name',
        'status',
        'icon',
        'type',
        'region',

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
        'status' => GameServerStatus::class,
        'restored_at' => 'datetime',
    ];
 
    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 
     //
 
     /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */
 

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', GameServerStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', GameServerStatus::INACTIVE);
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
 
}