<?php

namespace App\Services;

use App\Models\CloudinaryFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CloudinaryService
{
    /**
     * Upload a file to Cloudinary
     *
     * @param UploadedFile $file
     * @param array $options
     * @return CloudinaryFile|null
     */
    public function upload(UploadedFile $file, array $options = []): ?CloudinaryFile
    {
        try {
            $resourceType = $this->determineResourceType($file);
            $folder = $options['folder'] ?? $this->getDefaultFolder($resourceType);

            $uploadOptions = array_merge([
                'folder' => $folder,
                'resource_type' => $resourceType,
            ], $options['upload_options'] ?? []);

            // Upload to Cloudinary
            $result = Cloudinary::upload(
                $file->getRealPath(),
                $uploadOptions
            );

            // Prepare data for database
            $data = [
                'user_id' => $options['user_id'] ?? auth()->id(),
                'public_id' => $result->getPublicId(),
                'url' => $result->getSecurePath(),
                'resource_type' => $resourceType,
                'format' => $result->getExtension(),
                'folder' => $folder,
                'size' => $result->getSize(),
                'original_filename' => $file->getClientOriginalName(),
                'description' => $options['description'] ?? null,
                'tags' => $options['tags'] ?? [],
                'metadata' => $options['metadata'] ?? [],
            ];

            // Add type-specific data
            if ($resourceType === 'image') {
                $data['width'] = $result->getWidth();
                $data['height'] = $result->getHeight();
            } elseif ($resourceType === 'video') {
                $data['width'] = $result->getWidth() ?? null;
                $data['height'] = $result->getHeight() ?? null;
                $data['duration'] = $result->getResponse()['duration'] ?? null;
            }

            // Save to database
            return CloudinaryFile::create($data);
        } catch (\Exception $e) {
            Log::error('Cloudinary Upload Error', [
                'file' => $file->getClientOriginalName(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Upload multiple files
     *
     * @param array $files
     * @param array $options
     * @return array
     */
    public function uploadMultiple(array $files, array $options = []): array
    {
        $uploaded = [];
        $failed = [];

        foreach ($files as $file) {
            $result = $this->upload($file, $options);

            if ($result) {
                $uploaded[] = $result;
            } else {
                $failed[] = $file->getClientOriginalName();
            }
        }

        return [
            'uploaded' => $uploaded,
            'failed' => $failed,
            'success_count' => count($uploaded),
            'failed_count' => count($failed),
        ];
    }

    /**
     * Delete a file from Cloudinary
     *
     * @param string|CloudinaryFile $file
     * @param array $options
     * @return bool
     */
    public function delete($file, array $options = []): bool
    {
        try {
            $publicId = $file instanceof CloudinaryFile ? $file->public_id : $file;

            // Delete from Cloudinary
            Cloudinary::destroy($publicId, $options);

            // Delete from database if CloudinaryFile instance
            if ($file instanceof CloudinaryFile) {
                $file->delete();
            } elseif (is_string($file)) {
                CloudinaryFile::where('public_id', $file)->delete();
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary Delete Error', [
                'public_id' => $publicId ?? 'unknown',
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Delete multiple files
     *
     * @param array $files
     * @param array $options
     * @return array
     */
    public function deleteMultiple(array $files, array $options = []): array
    {
        $deleted = [];
        $failed = [];

        foreach ($files as $file) {
            $publicId = $file instanceof CloudinaryFile ? $file->public_id : $file;

            if ($this->delete($file, $options)) {
                $deleted[] = $publicId;
            } else {
                $failed[] = $publicId;
            }
        }

        return [
            'deleted' => $deleted,
            'failed' => $failed,
            'success_count' => count($deleted),
            'failed_count' => count($failed),
        ];
    }

    /**
     * Update file metadata in database
     *
     * @param CloudinaryFile $file
     * @param array $data
     * @return bool
     */
    public function updateMetadata(CloudinaryFile $file, array $data): bool
    {
        try {
            $file->update($data);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary Update Metadata Error', [
                'file_id' => $file->id,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get transformed URL for an image
     *
     * @param string|CloudinaryFile $file
     * @param array $transformations
     * @return string|null
     */
    public function getTransformedUrl($file, array $transformations = []): ?string
    {
        try {
            if ($file instanceof CloudinaryFile) {
                return $file->getTransformedUrl($transformations);
            }

            // If it's a public_id string
            if (empty($transformations)) {
                return cloudinary()->getUrl($file);
            }

            $parts = [];
            foreach ($transformations as $key => $value) {
                $parts[] = "{$key}_{$value}";
            }
            $transformation = implode(',', $parts);

            return cloudinary()->getUrl($file, ['transformation' => $transformation]);
        } catch (\Exception $e) {
            Log::error('Cloudinary Get Transformed URL Error', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Generate thumbnail for image or video
     *
     * @param string|CloudinaryFile $file
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function generateThumbnail($file, int $width = 150, int $height = 150): ?string
    {
        return $this->getTransformedUrl($file, [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'quality' => 'auto',
        ]);
    }

    /**
     * Replace an existing file
     *
     * @param CloudinaryFile $oldFile
     * @param UploadedFile $newFile
     * @param array $options
     * @return CloudinaryFile|null
     */
    public function replace(CloudinaryFile $oldFile, UploadedFile $newFile, array $options = []): ?CloudinaryFile
    {
        try {
            // Upload new file
            $newUpload = $this->upload($newFile, $options);

            if ($newUpload) {
                // Delete old file
                $this->delete($oldFile);
                return $newUpload;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Cloudinary Replace Error', [
                'old_file_id' => $oldFile->id,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get files by user
     *
     * @param int|null $userId
     * @param string|null $resourceType
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilesByUser(?int $userId = null, ?string $resourceType = null)
    {
        $query = CloudinaryFile::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($resourceType) {
            $query->where('resource_type', $resourceType);
        }

        return $query->latest()->get();
    }

    /**
     * Search files
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchFiles(array $criteria)
    {
        $query = CloudinaryFile::query();

        if (isset($criteria['user_id'])) {
            $query->where('user_id', $criteria['user_id']);
        }

        if (isset($criteria['resource_type'])) {
            $query->where('resource_type', $criteria['resource_type']);
        }

        if (isset($criteria['format'])) {
            $query->where('format', $criteria['format']);
        }

        if (isset($criteria['folder'])) {
            $query->where('folder', 'like', $criteria['folder'] . '%');
        }

        if (isset($criteria['tags'])) {
            $tags = is_array($criteria['tags']) ? $criteria['tags'] : [$criteria['tags']];
            foreach ($tags as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        if (isset($criteria['search'])) {
            $query->where(function ($q) use ($criteria) {
                $q->where('original_filename', 'like', '%' . $criteria['search'] . '%')
                    ->orWhere('description', 'like', '%' . $criteria['search'] . '%');
            });
        }

        return $query->latest()->get();
    }

    /**
     * Determine resource type based on file mime type
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function determineResourceType(UploadedFile $file): string
    {
        $mimeType = $file->getMimeType();

        if (Str::startsWith($mimeType, 'image/')) {
            return 'image';
        }

        if (Str::startsWith($mimeType, 'video/')) {
            return 'video';
        }

        if (Str::startsWith($mimeType, 'audio/')) {
            return 'video'; // Cloudinary uses 'video' for audio files
        }

        // For documents and other files
        return 'raw';
    }

    /**
     * Get default folder based on resource type
     *
     * @param string $resourceType
     * @return string
     */
    protected function getDefaultFolder(string $resourceType): string
    {
        $prefix = env('CLOUDINARY_PREFIX', 'swapy');

        return match ($resourceType) {
            'image' => "{$prefix}/uploads/images",
            'video' => "{$prefix}/uploads/videos",
            'raw' => "{$prefix}/uploads/documents",
            default => "{$prefix}/uploads/files",
        };
    }

    /**
     * Get file info from Cloudinary (useful for syncing)
     *
     * @param string $publicId
     * @return array|null
     */
    public function getFileInfo(string $publicId): ?array
    {
        try {
            $response = Cloudinary::getResource($publicId);
            return $response;
        } catch (\Exception $e) {
            Log::error('Cloudinary Get File Info Error', [
                'public_id' => $publicId,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
