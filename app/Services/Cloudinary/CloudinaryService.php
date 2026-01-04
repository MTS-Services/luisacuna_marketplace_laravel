<?php

namespace App\Services\Cloudinary;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CloudinaryService
{
    /**
     * Supported file types configuration
     */
    private const RESOURCE_TYPES = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico', 'tiff'],
        'video' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', '3gp'],
        'raw' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip', 'rar'],
        'audio' => ['mp3', 'wav', 'aac', 'ogg', 'flac'],
    ];

    /**
     * Upload file to Cloudinary
     *
     * @param UploadedFile|string $file File to upload (UploadedFile or path)
     * @param array $options Upload options
     * @return CloudinaryUploadResult
     * @throws \Exception
     */
    public function upload($file, array $options = []): CloudinaryUploadResult
    {
        try {
            // Determine file path
            $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

            // Get original filename
            $originalFilename = $file instanceof UploadedFile
                ? $file->getClientOriginalName()
                : basename($file);

            // Detect resource type
            $resourceType = $this->detectResourceType($file);

            // Merge default options
            $uploadOptions = array_merge([
                'folder' => $this->getDefaultFolder($resourceType),
                'resource_type' => $resourceType,
                'use_filename' => true,
                'unique_filename' => true,
            ], $options);

            // Upload using cloudinary() helper or UploadApi
            if ($resourceType === 'video') {
                $result = cloudinary()->uploadApi()->upload($filePath, $uploadOptions);
            } else {
                $result = cloudinary()->uploadApi()->upload($filePath, $uploadOptions);
            }

            // Extract data from result
            return new CloudinaryUploadResult(
                publicId: $result['public_id'],
                url: $result['url'],
                secureUrl: $result['secure_url'],
                resourceType: $resourceType,
                format: $result['format'] ?? '',
                size: $result['bytes'] ?? 0,
                width: $result['width'] ?? null,
                height: $result['height'] ?? null,
                duration: $result['duration'] ?? null,
                originalFilename: $originalFilename,
                metadata: $this->extractMetadata($result)
            );
        } catch (\Exception $e) {
            Log::error('Cloudinary Upload Failed', [
                'error' => $e->getMessage(),
                'file' => $originalFilename ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            throw new \Exception("Failed to upload file: {$e->getMessage()}");
        }
    }

    /**
     * Upload multiple files
     *
     * @param array $files Array of UploadedFile objects
     * @param array $options Upload options
     * @return array Array of CloudinaryUploadResult objects
     */
    public function uploadMultiple(array $files, array $options = []): array
    {
        $results = [];

        foreach ($files as $file) {
            try {
                $results[] = $this->upload($file, $options);
            } catch (\Exception $e) {
                Log::error('Failed to upload file in batch', [
                    'file' => $file instanceof UploadedFile ? $file->getClientOriginalName() : 'unknown',
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }

        return $results;
    }

    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId Public ID of the file
     * @param string $resourceType Resource type (image, video, raw)
     * @return bool
     */
    public function delete(string $publicId, string $resourceType = 'image'): bool
    {
        try {
            Log::info('Deleting file from Cloudinary', [
                'public_id' => $publicId,
                'resource_type' => $resourceType,
            ]);

            // Delete using cloudinary() helper or UploadApi)
            $result = cloudinary()->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
                'invalidate' => true,
            ]);

            return isset($result['result']) && $result['result'] === 'ok';
        } catch (\Exception $e) {
            Log::error('Cloudinary Delete Failed', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Delete multiple files
     *
     * @param array $publicIds Array of public IDs
     * @param string $resourceType Resource type
     * @return array ['success' => int, 'failed' => int]
     */
    public function deleteMultiple(array $publicIds, string $resourceType = 'image'): array
    {
        $success = 0;
        $failed = 0;

        foreach ($publicIds as $publicId) {
            if ($this->delete($publicId, $resourceType)) {
                $success++;
            } else {
                $failed++;
            }
        }

        return compact('success', 'failed');
    }

    /**
     * Get file information from Cloudinary
     *
     * @param string $publicId
     * @param string $resourceType
     * @return array|null
     */
    public function getFileInfo(string $publicId, string $resourceType = 'image')
    {
        try {
            $result = cloudinary()->adminApi()->asset($publicId, [
                'resource_type' => $resourceType,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to get Cloudinary file info', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Generate transformation URL
     *
     * @param string $publicId
     * @param array $transformations
     * @param string $resourceType
     * @return string
     */
    public function getTransformedUrl(string $publicId, array $transformations, string $resourceType = 'image'): string
    {
        try {
            return cloudinary()->image($publicId)
                ->addTransformation($transformations)
                ->toUrl();
        } catch (\Exception $e) {
            Log::error('Failed to generate transformed URL', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);

            return '';
        }
    }

    /**
     * Rename/move file in Cloudinary
     *
     * @param string $fromPublicId
     * @param string $toPublicId
     * @param string $resourceType
     * @return bool
     */
    public function rename(string $fromPublicId, string $toPublicId, string $resourceType = 'image'): bool
    {
        try {
            $result = cloudinary()->uploadApi()->rename($fromPublicId, $toPublicId, [
                'resource_type' => $resourceType,
                'overwrite' => false,
            ]);

            return isset($result['public_id']) && $result['public_id'] === $toPublicId;
        } catch (\Exception $e) {
            Log::error('Cloudinary Rename Failed', [
                'from' => $fromPublicId,
                'to' => $toPublicId,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Create a folder in Cloudinary
     *
     * @param string $folderPath
     * @return bool
     */
    public function createFolder(string $folderPath): bool
    {
        try {
            cloudinary()->adminApi()->createFolder($folderPath);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to create Cloudinary folder', [
                'folder' => $folderPath,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Detect resource type based on file
     *
     * @param UploadedFile|string $file
     * @return string
     */
    private function detectResourceType($file): string
    {
        $extension = $file instanceof UploadedFile
            ? strtolower($file->getClientOriginalExtension())
            : strtolower(pathinfo($file, PATHINFO_EXTENSION));

        foreach (self::RESOURCE_TYPES as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type === 'audio' ? 'video' : $type;
            }
        }

        return 'raw';
    }

    /**
     * Get default folder based on resource type
     *
     * @param string $resourceType
     * @return string
     */
    private function getDefaultFolder(string $resourceType): string
    {
        $prefix = env('CLOUDINARY_PREFIX', 'app');

        return match ($resourceType) {
            'image' => "{$prefix}/images",
            'video' => "{$prefix}/videos",
            'raw' => "{$prefix}/documents",
            default => "{$prefix}/files",
        };
    }

    /**
     * Extract useful metadata from response
     *
     * @param array $response
     * @return array
     */
    private function extractMetadata($response): array
    {
        return [
            'created_at' => $response['created_at'] ?? null,
            'bytes' => $response['bytes'] ?? null,
            'type' => $response['type'] ?? null,
            'etag' => $response['etag'] ?? null,
            'placeholder' => $response['placeholder'] ?? false,
            'url' => $response['url'] ?? null,
            'secure_url' => $response['secure_url'] ?? null,
        ];
    }

    /**
     * Validate file before upload
     *
     * @param UploadedFile $file
     * @param array $rules ['max_size' => 10240, 'allowed_types' => ['image', 'video']]
     * @return bool
     * @throws \Exception
     */
    public function validateFile(UploadedFile $file, array $rules = []): bool
    {
        // Check max size (in KB)
        if (isset($rules['max_size'])) {
            $maxSizeKb = $rules['max_size'];
            $fileSizeKb = $file->getSize() / 1024;

            if ($fileSizeKb > $maxSizeKb) {
                throw new \Exception("File size ({$fileSizeKb}KB) exceeds maximum allowed size ({$maxSizeKb}KB)");
            }
        }

        // Check allowed resource types
        if (isset($rules['allowed_types'])) {
            $resourceType = $this->detectResourceType($file);

            if (!in_array($resourceType, $rules['allowed_types'])) {
                throw new \Exception("File type '{$resourceType}' is not allowed");
            }
        }

        // Check allowed extensions
        if (isset($rules['allowed_extensions'])) {
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $rules['allowed_extensions'])) {
                throw new \Exception("File extension '{$extension}' is not allowed");
            }
        }

        return true;
    }
}
