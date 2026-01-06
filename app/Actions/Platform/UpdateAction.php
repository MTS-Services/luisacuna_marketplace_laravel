<?php

namespace App\Actions\Platform;

use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{
    public function __construct(
        protected PlatformRepositoryInterface $interface,
        protected CloudinaryService $cloudinaryService
    ) {
    }

    public function execute(int $id, array $data): Platform
    {
        $newSingleIconPath = null;

        return DB::transaction(function () use ($id, $data, &$newSingleIconPath) {

            $findData = $this->interface->find($id);

            if (!$findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception('Data not found');
            }


                $oldData = $findData->getAttributes();
                $newData = $data;

                // --- 1. Single Avatar Handling ---
                $oldIconPath = Arr::get($oldData, 'icon');
                $uploadedIcon = Arr::get($data, 'icon');

                if ($uploadedIcon instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if ($oldIconPath) {
                       $this->cloudinaryService->delete($oldIconPath);
                    }

                    $newSingleIconPath = $this->cloudinaryService->upload($uploadedIcon, ['folder' => 'platforms']);
                    $newSingleIconPath = $newSingleIconPath->publicId;
                    $newData['icon'] = $newSingleIconPath;

                 
                } elseif (Arr::get($data, 'remove_file')) {
                    if ($oldIconPath) {
                       $this->cloudinaryService->delete($oldIconPath);
                    }
                    $newData['icon'] = null;
                }
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleIconPath) {
                    $newData['icon'] = $oldAvatarPath ?? null;
                }
                unset($newData['remove_file']);

         
            
            $updated = $this->interface->update($id, $newData);

          
            if (!$updated) {

                Log::error('Failed to update data in repository', ['data_id' => $id]);

                throw new \Exception('Failed to update data');
            }

            return $findData->fresh();
        });
    }
}
