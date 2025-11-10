<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\ProductRepositoryInterface;


class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    ) {}


    public function execute(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            // fatch Product 
            $product = $this->interface->find($id);

            if (!$product) {
                Log::error('Data not found', ['product_id' => $id]);
                throw new \Exception('data not found');
            }
            $oldData = $product->getAttributes();



            // ========== Image Handling Start ==========
            // Extract image related data
            $newImages = $data['images'] ?? [];
            $imagesToDelete = $data['images_to_delete'] ?? [];
            $existingImages = $data['existing_images'] ?? [];

            // Remove image data from main data array
            unset($data['images'], $data['images_to_delete'], $data['existing_images']);



            // Update Product 
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Product', ['product_id' => $id]);
                throw new \Exception('Failed to update Product');
            }



            // Handle Image Operations
            if (!empty($imagesToDelete)) {
                $this->deleteImages($product, $imagesToDelete);
            }

            if (!empty($existingImages)) {
                $this->updateExistingImages($product, $existingImages);
            }

            if (!empty($newImages)) {
                $this->handleNewImages($product, $newImages);
            }
            // ========== Image Handling End ==========


            // Refresh model
            $product = $product->fresh();

            // Detect changes
            $changes = [];
            foreach ($product->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'from' => $oldData[$key],
                        'to' => $value,
                    ];
                }
            }
            return [$product, $changes];
        });
    }


     /**
     * Delete marked images
     */
    protected function deleteImages($product, array $imageIds): void
    {
        try {
            $images = $product->images()->whereIn('id', $imageIds)->get();

            foreach ($images as $image) {
                // Delete from storage
                if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
                    Storage::disk('public')->delete($image->thumbnail_path);
                }

                // Delete from database
                $image->delete();
            }

            Log::info('Images deleted successfully', [
                'product_id' => $product->id,
                'image_ids' => $imageIds
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete images', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update existing images (primary status, sort order)
     */
    protected function updateExistingImages($product, array $existingImages): void
    {
        try {
            foreach ($existingImages as $imageData) {
                if (isset($imageData['id'])) {
                    $product->images()->where('id', $imageData['id'])->update([
                        'is_primary' => $imageData['is_primary'] ?? false,
                        'sort_order' => $imageData['sort_order'] ?? 0,
                    ]);
                }
            }

            Log::info('Existing images updated', [
                'product_id' => $product->id,
                'images_count' => count($existingImages)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update existing images', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Handle new image uploads
     */
    protected function handleNewImages($product, array $images): void
    {
        try {
            // Get max sort order
            $maxSortOrder = $product->images()->max('sort_order') ?? -1;

            // Check if primary image exists
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($images as $index => $image) {
                // Upload image
                $imagePath = $image->store('products/images', 'public');
                
                // First image will be primary if no primary exists
                $isPrimary = !$hasPrimary && $index === 0;

                // Create image record
                $product->images()->create([
                    'image_path' => $imagePath,
                    'thumbnail_path' => null,
                    'is_primary' => $isPrimary,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'creater_id' => $product->creater_id,
                    'creater_type' => $product->creater_type,
                ]);

                if ($isPrimary) {
                    $hasPrimary = true;
                }
            }

            Log::info('New images uploaded', [
                'product_id' => $product->id,
                'images_count' => count($images)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to upload new images', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
