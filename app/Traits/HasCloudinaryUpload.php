<?php

namespace App\Traits;

use App\Models\CloudinaryFile;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

trait HasCloudinaryUpload
{
    /**
     * Get Cloudinary service instance
     *
     * @return CloudinaryService
     */
    protected function cloudinaryService(): CloudinaryService
    {
        return app(CloudinaryService::class);
    }

    /**
     * Upload a file to Cloudinary
     *
     * @param UploadedFile $file
     * @param array $options
     * @return CloudinaryFile|null
     */
    public function uploadToCloudinary(UploadedFile $file, array $options = []): ?CloudinaryFile
    {
        // Auto-set user_id if model has user relationship
        if (!isset($options['user_id']) && method_exists($this, 'user')) {
            $options['user_id'] = $this->user_id ?? auth()->id();
        }

        return $this->cloudinaryService()->upload($file, $options);
    }

    /**
     * Upload multiple files to Cloudinary
     *
     * @param array $files
     * @param array $options
     * @return array
     */
    public function uploadMultipleToCloudinary(array $files, array $options = []): array
    {
        if (!isset($options['user_id']) && method_exists($this, 'user')) {
            $options['user_id'] = $this->user_id ?? auth()->id();
        }

        return $this->cloudinaryService()->uploadMultiple($files, $options);
    }

    /**
     * Delete a file from Cloudinary
     *
     * @param string|CloudinaryFile $file
     * @param array $options
     * @return bool
     */
    public function deleteFromCloudinary($file, array $options = []): bool
    {
        return $this->cloudinaryService()->delete($file, $options);
    }

    /**
     * Delete multiple files from Cloudinary
     *
     * @param array $files
     * @param array $options
     * @return array
     */
    public function deleteMultipleFromCloudinary(array $files, array $options = []): array
    {
        return $this->cloudinaryService()->deleteMultiple($files, $options);
    }

    /**
     * Get transformed URL
     *
     * @param string|CloudinaryFile $file
     * @param array $transformations
     * @return string|null
     */
    public function getCloudinaryTransformedUrl($file, array $transformations = []): ?string
    {
        return $this->cloudinaryService()->getTransformedUrl($file, $transformations);
    }

    /**
     * Generate thumbnail
     *
     * @param string|CloudinaryFile $file
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function generateCloudinaryThumbnail($file, int $width = 150, int $height = 150): ?string
    {
        return $this->cloudinaryService()->generateThumbnail($file, $width, $height);
    }

    /**
     * Replace an existing file
     *
     * @param CloudinaryFile $oldFile
     * @param UploadedFile $newFile
     * @param array $options
     * @return CloudinaryFile|null
     */
    public function replaceCloudinaryFile(CloudinaryFile $oldFile, UploadedFile $newFile, array $options = []): ?CloudinaryFile
    {
        return $this->cloudinaryService()->replace($oldFile, $newFile, $options);
    }

    /**
     * Get user's files
     *
     * @param string|null $resourceType
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCloudinaryFiles(?string $resourceType = null)
    {
        $userId = $this->id ?? auth()->id();
        return $this->cloudinaryService()->getFilesByUser($userId, $resourceType);
    }

    /**
     * Search files
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchCloudinaryFiles(array $criteria = [])
    {
        if (!isset($criteria['user_id'])) {
            $criteria['user_id'] = $this->id ?? auth()->id();
        }

        return $this->cloudinaryService()->searchFiles($criteria);
    }
}
