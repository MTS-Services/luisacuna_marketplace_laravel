<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class EmailTemplate extends BaseModel implements Auditable
{
    use  AuditableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'key',
        'name',
        'subject',
        'template',
        'variables',



        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected $casts = [
        'variables' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('key', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%");
        });
    }
    public function scopeFilder($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['key'] ?? null, fn($q, $key) => $q->where('key', $key));
        $query->when($filters['name'] ?? null, fn($q, $name) => $q->where('name', $name));
        return $query;
    }



    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */





    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
}
