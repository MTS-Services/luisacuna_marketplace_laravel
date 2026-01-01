<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CloudinaryService
{
    protected $cloudinary;

    // File type constants
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_RAW = 'raw';
    const TYPE_AUTO = 'auto';

    // Default folders
    const FOLDER_IMAGES = 'laravel-app/images';
    const FOLDER_VIDEOS = 'laravel-app/videos';
    const FOLDER_DOCUMENTS = 'laravel-app/documents';
    const FOLDER_AUDIO = 'laravel-app/audio';

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    /**
     * Upload any file type to Cloudinary with optimization
     * 
     * @param UploadedFile|string $file
     * @param array $options
     * @return array
     */
    public function upload($file, array $options = []): array
    {
        try {
            $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;
            $mimeType = $file instanceof UploadedFile ? $file->getMimeType() : mime_content_type($file);

            // Determine resource type
            $resourceType = $this->determineResourceType($mimeType, $options);

            // Set default folder based on type
            $folder = $options['folder'] ?? $this->getDefaultFolder($resourceType);

            // Build upload options
            $uploadOptions = array_merge([
                'folder' => $folder,
                'resource_type' => $resourceType,
                'use_filename' => true,
                'unique_filename' => true,
                'overwrite' => false,
            ], $options);

            // Apply type-specific optimizations
            $uploadOptions = $this->applyOptimizations($uploadOptions, $resourceType, $mimeType);

            // Upload to Cloudinary
            $result = $this->cloudinary->uploadApi()->upload($filePath, $uploadOptions);

            // Convert ApiResponse to array
            $resultArray = $result->getArrayCopy();

            Log::info('Cloudinary upload successful', [
                'public_id' => $resultArray['public_id'],
                'resource_type' => $resultArray['resource_type'],
                'format' => $resultArray['format'],
            ]);

            return $this->formatResponse($resultArray);
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Upload image with specific optimizations
     */
    public function uploadImage($file, array $options = []): array
    {
        $defaultOptions = [
            'folder' => self::FOLDER_IMAGES,
            'resource_type' => self::TYPE_IMAGE,
            'transformation' => [
                'quality' => 'auto:best',
                'fetch_format' => 'auto',
            ]
        ];

        return $this->upload($file, array_merge($defaultOptions, $options));
    }

    /**
     * Upload video with specific optimizations
     */
    public function uploadVideo($file, array $options = []): array
    {
        $defaultOptions = [
            'folder' => self::FOLDER_VIDEOS,
            'resource_type' => self::TYPE_VIDEO,
            'eager' => [
                ['streaming_profile' => 'hd', 'format' => 'm3u8'],
            ],
            'eager_async' => true,
        ];

        return $this->upload($file, array_merge($defaultOptions, $options));
    }

    /**
     * Upload document/raw file
     */
    public function uploadDocument($file, array $options = []): array
    {
        $defaultOptions = [
            'folder' => self::FOLDER_DOCUMENTS,
            'resource_type' => self::TYPE_RAW,
        ];

        return $this->upload($file, array_merge($defaultOptions, $options));
    }

    /**
     * Upload audio file
     */
    public function uploadAudio($file, array $options = []): array
    {
        $defaultOptions = [
            'folder' => self::FOLDER_AUDIO,
            'resource_type' => self::TYPE_VIDEO, // Cloudinary treats audio as video
        ];

        return $this->upload($file, array_merge($defaultOptions, $options));
    }

    /**
     * Delete a resource from Cloudinary
     */
    public function destroy(string $publicId, string $resourceType = self::TYPE_IMAGE): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
                'invalidate' => true,
            ]);

            // Convert ApiResponse to array
            $resultArray = is_array($result) ? $result : $result->getArrayCopy();

            Log::info('Cloudinary resource deleted', [
                'public_id' => $publicId,
                'result' => $resultArray['result'] ?? 'unknown'
            ]);

            return [
                'success' => ($resultArray['result'] ?? '') === 'ok',
                'public_id' => $publicId,
                'result' => $resultArray
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete multiple resources
     */
    public function destroyMultiple(array $publicIds, string $resourceType = self::TYPE_IMAGE): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->deleteResources($publicIds, [
                'resource_type' => $resourceType,
                'invalidate' => true,
            ]);

            // Convert ApiResponse to array
            $resultArray = is_array($result) ? $result : $result->getArrayCopy();

            Log::info('Cloudinary batch delete completed', [
                'count' => count($publicIds),
                'deleted' => $resultArray['deleted'] ?? []
            ]);

            return [
                'success' => true,
                'deleted' => $resultArray['deleted'] ?? [],
                'partial' => $resultArray['partial'] ?? false,
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary batch delete failed', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete resources by prefix (folder)
     */
    public function destroyByPrefix(string $prefix, string $resourceType = self::TYPE_IMAGE): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->deleteResourcesByPrefix($prefix, [
                'resource_type' => $resourceType,
                'invalidate' => true,
            ]);

            // Convert ApiResponse to array
            $resultArray = is_array($result) ? $result : $result->getArrayCopy();

            return [
                'success' => true,
                'result' => $resultArray
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary delete by prefix failed', [
                'prefix' => $prefix,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get optimized URL for a resource
     */
    public function getUrl(string $publicId, array $transformations = [], string $resourceType = self::TYPE_IMAGE): string
    {
        try {
            if ($resourceType === self::TYPE_VIDEO) {
                return $this->cloudinary->video($publicId)
                    ->toUrl();
            }

            return $this->cloudinary->image($publicId)->toUrl();
        } catch (\Exception $e) {
            Log::error('Failed to generate Cloudinary URL', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    /**
     * Get resource details
     */
    public function getResourceDetails(string $publicId, string $resourceType = self::TYPE_IMAGE): array
    {
        try {
            $result = $this->cloudinary->adminApi()->asset($publicId, [
                'resource_type' => $resourceType
            ]);

            // Convert ApiResponse to array
            return is_array($result) ? $result : $result->getArrayCopy();
        } catch (\Exception $e) {
            Log::error('Failed to fetch resource details', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Create a ZIP archive of resources
     */
    public function createArchive(array $publicIds, string $targetPublicId = null): array
    {
        try {
            $options = [
                'public_ids' => $publicIds,
                'resource_type' => self::TYPE_IMAGE,
            ];

            if ($targetPublicId) {
                $options['target_public_id'] = $targetPublicId;
            }

            $result = $this->cloudinary->uploadApi()->createArchive($options);

            // Convert ApiResponse to array
            $resultArray = is_array($result) ? $result : $result->getArrayCopy();

            return [
                'success' => true,
                'url' => $resultArray['secure_url'] ?? $resultArray['url'],
                'public_id' => $resultArray['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create archive', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Rename a resource
     */
    public function rename(string $fromPublicId, string $toPublicId, string $resourceType = self::TYPE_IMAGE): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->rename($fromPublicId, $toPublicId, [
                'resource_type' => $resourceType,
                'overwrite' => false,
                'invalidate' => true,
            ]);

            // Convert ApiResponse to array
            $resultArray = is_array($result) ? $result : $result->getArrayCopy();

            return [
                'success' => true,
                'public_id' => $resultArray['public_id'],
                'url' => $resultArray['secure_url'],
            ];
        } catch (\Exception $e) {
            Log::error('Failed to rename resource', [
                'from' => $fromPublicId,
                'to' => $toPublicId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Determine resource type from MIME type
     */
    protected function determineResourceType(string $mimeType, array $options): string
    {
        if (isset($options['resource_type'])) {
            return $options['resource_type'];
        }

        // Image types
        if (Str::startsWith($mimeType, 'image/')) {
            return self::TYPE_IMAGE;
        }

        // Video types
        if (Str::startsWith($mimeType, 'video/')) {
            return self::TYPE_VIDEO;
        }

        // Audio types (treated as video in Cloudinary)
        if (Str::startsWith($mimeType, 'audio/')) {
            return self::TYPE_VIDEO;
        }

        // GIF can be either image or video
        if ($mimeType === 'image/gif') {
            return $options['treat_gif_as_video'] ?? false ? self::TYPE_VIDEO : self::TYPE_IMAGE;
        }

        // Everything else as raw
        return self::TYPE_RAW;
    }

    /**
     * Get default folder based on resource type
     */
    protected function getDefaultFolder(string $resourceType): string
    {
        return match ($resourceType) {
            self::TYPE_IMAGE => self::FOLDER_IMAGES,
            self::TYPE_VIDEO => self::FOLDER_VIDEOS,
            self::TYPE_RAW => self::FOLDER_DOCUMENTS,
            default => 'laravel-app/uploads',
        };
    }

    /**
     * Apply type-specific optimizations
     */
    protected function applyOptimizations(array $options, string $resourceType, string $mimeType): array
    {
        // Image optimizations
        if ($resourceType === self::TYPE_IMAGE) {
            $options['transformation'] = array_merge([
                'quality' => 'auto:best',
                'fetch_format' => 'auto',
            ], $options['transformation'] ?? []);

            // Progressive JPEG
            if (Str::contains($mimeType, 'jpeg')) {
                $options['transformation']['flags'] = 'progressive';
            }
        }

        // Video optimizations
        if ($resourceType === self::TYPE_VIDEO && Str::startsWith($mimeType, 'video/')) {
            $options = array_merge([
                'eager' => [
                    ['streaming_profile' => 'hd', 'format' => 'm3u8'],
                ],
                'eager_async' => true,
            ], $options);
        }

        return $options;
    }

    /**
     * Format API response
     */
    protected function formatResponse(array $result): array
    {
        return [
            'success' => true,
            'public_id' => $result['public_id'],
            'url' => $result['secure_url'] ?? $result['url'],
            'resource_type' => $result['resource_type'],
            'format' => $result['format'] ?? null,
            'width' => $result['width'] ?? null,
            'height' => $result['height'] ?? null,
            'size' => $result['bytes'] ?? null,
            'duration' => $result['duration'] ?? null, // For videos
            'created_at' => $result['created_at'] ?? null,
            'raw' => $result, // Full response for reference
        ];
    }

    /**
     * Validate file before upload
     */
    public function validateFile(UploadedFile $file, array $rules = []): array
    {
        $errors = [];

        // Check file size (default 100MB)
        $maxSize = $rules['max_size'] ?? 100 * 1024 * 1024;
        if ($file->getSize() > $maxSize) {
            $errors[] = "File size exceeds maximum allowed size of " . ($maxSize / 1024 / 1024) . "MB";
        }

        // Check allowed MIME types
        if (isset($rules['allowed_types'])) {
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, $rules['allowed_types'])) {
                $errors[] = "File type not allowed: {$mimeType}";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }
}
