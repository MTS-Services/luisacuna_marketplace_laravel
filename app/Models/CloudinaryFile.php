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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'formatted_size',
        'is_image',
        'is_video',
        'is_document',
        'thumbnail_url',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute()
    {
        if (!$this->size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Check if file is an image
     */
    public function getIsImageAttribute()
    {
        return $this->resource_type === 'image';
    }

    /**
     * Check if file is a video
     */
    public function getIsVideoAttribute()
    {
        return $this->resource_type === 'video';
    }

    /**
     * Check if file is a document
     */
    public function getIsDocumentAttribute()
    {
        return $this->resource_type === 'raw';
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->is_image) {
            return $this->getTransformedUrl([
                'width' => 150,
                'height' => 150,
                'crop' => 'fill',
                'quality' => 'auto',
            ]);
        }

        return $this->url;
    }

    /**
     * Get transformed URL
     */
    public function getTransformedUrl(array $transformations = [])
    {
        if (empty($transformations)) {
            return $this->url;
        }

        // Build transformation string
        $parts = [];
        foreach ($transformations as $key => $value) {
            $parts[] = "{$key}_{$value}";
        }
        $transformation = implode(',', $parts);

        // Insert transformation into URL
        return str_replace('/upload/', "/upload/{$transformation}/", $this->url);
    }

    /**
     * Delete file from Cloudinary when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            try {
                Cloudinary::destroy($file->public_id);
            } catch (\Exception $e) {
                Log::error('Failed to delete file from Cloudinary: ' . $e->getMessage());
            }
        });
    }
}