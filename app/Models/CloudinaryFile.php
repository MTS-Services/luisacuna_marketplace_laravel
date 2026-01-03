<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'public_id',
        'url',
        'resource_type',
        'format',
        'folder',
        'size',
        'width',
        'height',
        'duration',
        'original_filename',
        'description',
        'tags',
        'metadata',
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'duration' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method - auto delete from Cloudinary
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            try {
                Cloudinary::destroy($file->public_id, [
                    'resource_type' => $file->resource_type,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to delete file from Cloudinary', [
                    'public_id' => $file->public_id,
                    'error' => $e->getMessage()
                ]);
            }
        });
    }
}