<?php

namespace App\Services\Cloudinary;

class CloudinaryUploadResult
{
    public function __construct(
        public string $publicId,
        public string $url,
        public string $secureUrl,
        public string $resourceType,
        public string $format,
        public int $size,
        public ?int $width = null,
        public ?int $height = null,
        public ?float $duration = null,
        public ?string $originalFilename = null,
        public array $metadata = []
    ) {}

    /**
     * Convert to array for database storage
     */
    public function toArray(): array
    {
        return [
            'public_id' => $this->publicId,
            'url' => $this->secureUrl,
            'resource_type' => $this->resourceType,
            'format' => $this->format,
            'size' => $this->size,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
            'original_filename' => $this->originalFilename,
            'metadata' => $this->metadata,
        ];
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSize(): string
    {
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
     * Get thumbnail URL for images
     */
    public function getThumbnailUrl(int $width = 150, int $height = 150): string
    {
        if ($this->resourceType !== 'image') {
            return $this->secureUrl;
        }

        return str_replace(
            '/upload/',
            "/upload/w_{$width},h_{$height},c_fill,q_auto/",
            $this->secureUrl
        );
    }

    /**
     * Get transformed URL
     */
    public function getTransformedUrl(array $transformations): string
    {
        $parts = [];
        foreach ($transformations as $key => $value) {
            $parts[] = "{$key}_{$value}";
        }
        $transformation = implode(',', $parts);

        return str_replace('/upload/', "/upload/{$transformation}/", $this->secureUrl);
    }
}
