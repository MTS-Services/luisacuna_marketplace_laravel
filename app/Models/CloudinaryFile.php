<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * Boot method - Auto-delete from Cloudinary when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            if (!$file->isForceDeleting()) {
                return;
            }

            try {
                $cloudinaryService = app(CloudinaryService::class);
                $cloudinaryService->destroy($file->public_id, $file->resource_type);
            } catch (\Exception $e) {
                \Log::error('Failed to delete from Cloudinary during model deletion: ' . $e->getMessage());
            }
        });
    }

    /**
     * Accessors
     */
    public function getFormattedSizeAttribute(): string
    {
        if (!$this->size) {
            return 'Unknown';
        }

        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getIsImageAttribute(): bool
    {
        return $this->resource_type === 'image';
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->resource_type === 'video' && 
               in_array($this->format, ['mp4', 'webm', 'mov', 'avi', 'mkv', 'flv']);
    }

    public function getIsDocumentAttribute(): bool
    {
        return $this->resource_type === 'raw' || 
               in_array($this->format, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt']);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->is_image) {
            return $this->getTransformedUrl([
                'width' => 200,
                'height' => 200,
                'crop' => 'fill',
                'quality' => 'auto',
            ]);
        }

        if ($this->is_video) {
            // Get video thumbnail
            return str_replace('/video/upload/', '/video/upload/so_0,w_200,h_200,c_fill/', $this->url);
        }

        return null;
    }

    /**
     * Get transformed URL with specific options
     */
    public function getTransformedUrl(array $transformations = []): string
    {
        try {
            $cloudinaryService = app(CloudinaryService::class);
            return $cloudinaryService->getUrl($this->public_id, $transformations, $this->resource_type);
        } catch (\Exception $e) {
            \Log::error('Failed to generate transformed URL: ' . $e->getMessage());
            return $this->url;
        }
    }

    /**
     * Get responsive image URLs
     */
    public function getResponsiveUrls(): array
    {
        if (!$this->is_image) {
            return [];
        }

        $widths = [320, 640, 768, 1024, 1280, 1920];
        $urls = [];

        foreach ($widths as $width) {
            $urls[$width] = $this->getTransformedUrl([
                'width' => $width,
                'crop' => 'scale',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
        }

        return $urls;
    }

    /**
     * Scope queries
     */
    public function scopeImages($query)
    {
        return $query->where('resource_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('resource_type', 'video');
    }

    public function scopeDocuments($query)
    {
        return $query->where('resource_type', 'raw');
    }

    public function scopeInFolder($query, string $folder)
    {
        return $query->where('folder', $folder);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Helper methods
     */
    public function getIcon(): string
    {
        if ($this->is_image) {
            return '🖼️';
        }

        if ($this->is_video) {
            return '🎥';
        }

        return match($this->format) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            'ppt', 'pptx' => '📽️',
            'zip', 'rar' => '🗜️',
            'mp3', 'wav', 'ogg' => '🎵',
            default => '📎',
        };
    }

    public function getDurationFormatted(): ?string
    {
        if (!$this->duration) {
            return null;
        }

        $seconds = $this->duration;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}