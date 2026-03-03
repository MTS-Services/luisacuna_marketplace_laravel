<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisputeMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sort_order',
        'dispute_id',
        'sender_id',
        'sender_role',
        'message',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function dispute(): BelongsTo
    {
        return $this->belongsTo(Dispute::class, 'dispute_id', 'id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}

