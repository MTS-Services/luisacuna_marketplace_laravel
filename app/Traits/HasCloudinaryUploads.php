<?php

namespace App\Traits;

use App\Services\Cloudinary\CloudinaryService;
use App\Services\Cloudinary\CloudinaryUploadResult;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

trait HasCloudinaryUploads
{
    /**
     * Cloudinary service instance
     */
    protected ?CloudinaryService $cloudinaryService = null;

    /**
     * Get Cloudinary service instance
     */
    protected function cloudinary(): CloudinaryService
    {
        if ($this->cloudinaryService === null) {
            $this->cloudinaryService = app(CloudinaryService::class);
        }

        return $this->cloudinaryService;
    }

    /**
     * Upload single file to Cloudinary
     *
     * @param UploadedFile|string $file
     * @param array $options
     * @return CloudinaryUploadResult|null
     */
    protected function uploadToCloudinary($file, array $options = []): ?CloudinaryUploadResult
    {
        try {
            return $this->cloudinary()->upload($file, $options);
        } catch (\Exception $e) {
            $this->handleCloudinaryError('upload', $e);
            return null;
        }
    }

    /**
     * Upload multiple files to Cloudinary
     *
     * @param array $files
     * @param array $options
     * @return array
     */
    protected function uploadMultipleToCloudinary(array $files, array $options = []): array
    {
        return $this->cloudinary()->uploadMultiple($files, $options);
    }

    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @param string $resourceType
     * @return bool
     */
    protected function deleteFromCloudinary(string $publicId, string $resourceType = 'image'): bool
    {
        try {
            return $this->cloudinary()->delete($publicId, $resourceType);
        } catch (\Exception $e) {
            $this->handleCloudinaryError('delete', $e);
            return false;
        }
    }

    /**
     * Delete multiple files from Cloudinary
     *
     * @param array $publicIds
     * @param string $resourceType
     * @return array
     */
    protected function deleteMultipleFromCloudinary(array $publicIds, string $resourceType = 'image'): array
    {
        return $this->cloudinary()->deleteMultiple($publicIds, $resourceType);
    }

    /**
     * Get transformed URL
     *
     * @param string $publicId
     * @param array $transformations
     * @param string $resourceType
     * @return string
     */
    protected function getCloudinaryTransformedUrl(string $publicId, array $transformations, string $resourceType = 'image'): string
    {
        return $this->cloudinary()->getTransformedUrl($publicId, $transformations, $resourceType);
    }

    /**
     * Validate file before upload
     *
     * @param UploadedFile $file
     * @param array $rules
     * @return bool
     */
    protected function validateCloudinaryFile(UploadedFile $file, array $rules = []): bool
    {
        try {
            return $this->cloudinary()->validateFile($file, $rules);
        } catch (\Exception $e) {
            $this->addError('file', $e->getMessage());
            return false;
        }
    }

    /**
     * Handle Cloudinary errors
     *
     * @param string $operation
     * @param \Exception $e
     * @return void
     */
    protected function handleCloudinaryError(string $operation, \Exception $e): void
    {
        Log::error("Cloudinary {$operation} failed in " . get_class($this), [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        // Set error message for Livewire
        if (method_exists($this, 'dispatch')) {
            $this->dispatch('cloudinary-error', message: $e->getMessage());
        }

        // Set session flash if available
        if (function_exists('session')) {
            session()->flash('error', "Failed to {$operation} file: " . $e->getMessage());
        }
    }

    /**
     * Upload and save to database helper
     *
     * @param UploadedFile $file
     * @param string $modelClass
     * @param array $additionalData
     * @param array $uploadOptions
     * @return mixed|null
     */
    protected function uploadAndSave(
        UploadedFile $file,
        string $modelClass,
        array $additionalData = [],
        array $uploadOptions = []
    ) {
        try {
            // Upload to Cloudinary
            $result = $this->uploadToCloudinary($file, $uploadOptions);

            if (!$result) {
                return null;
            }

            // Merge with additional data
            $data = array_merge($result->toArray(), $additionalData);

            // Create database record
            return $modelClass::create($data);
        } catch (\Exception $e) {
            $this->handleCloudinaryError('upload and save', $e);
            return null;
        }
    }

    /**
     * Delete file and database record
     *
     * @param mixed $model Model instance with public_id and resource_type
     * @return bool
     */
    protected function deleteAndRemove($model): bool
    {
        try {
            // Delete from Cloudinary
            $deleted = $this->deleteFromCloudinary(
                $model->public_id,
                $model->resource_type ?? 'image'
            );

            if ($deleted) {
                // Delete from database
                $model->delete();
                return true;
            }

            return false;
        } catch (\Exception $e) {
            $this->handleCloudinaryError('delete and remove', $e);
            return false;
        }
    }
}
