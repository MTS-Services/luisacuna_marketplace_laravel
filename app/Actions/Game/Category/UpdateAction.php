<?php

namespace App\Actions\Game\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{

    public function __construct(protected CategoryRepositoryInterface $interface) {}
    public function execute(int $id, array $data): Category
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
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }
                    // Store the new file and track path for rollback
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedIcon->getClientOriginalName();

                    $newSingleIconPath = Storage::disk('public')->putFileAs('icons', $uploadedIcon, $fileName);
                    $newData['icon'] = $newSingleIconPath;
                } elseif (Arr::get($data, 'remove_file')) {
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }
                    $newData['icon'] = null;
                }
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleIconPath) {
                    $newData['icon'] = $oldIconPath ?? null;
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
