<?php

namespace App\Models;

use App\Enums\AttachmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DisputeAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sort_order',
        'dispute_id',
        'uploaded_by',
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'attachment_type',
    ];

    protected $casts = [
        'size' => 'integer',
        'attachment_type' => AttachmentType::class,
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

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

}

