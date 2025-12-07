<?php

namespace App\Actions\Game\Category;

use App\Models\Category;
use App\Jobs\TranslateCategoryJob;
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

        try {
            return DB::transaction(function () use ($id, $data, &$newSingleIconPath) {

                $findData = $this->interface->findData($id, 'id', false, false, false);

                if (!$findData) {
                    Log::error('Category not found', [
                        'category_id' => $id
                    ]);
                    throw new \Exception('Category not found');
                }

                $oldData = $findData->getAttributes();
                $newData = $data;

                // Check if name has changed (will trigger re-translation)
                $nameChanged = isset($newData['name']) && $newData['name'] !== $oldData['name'];

                // ---- SINGLE ICON HANDLING ----
                $oldIconPath = Arr::get($oldData, 'icon');
                $uploadedIcon = Arr::get($data, 'icon');

                if ($uploadedIcon instanceof UploadedFile) {
                    // Delete old file permanently
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }

                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedIcon->getClientOriginalName();

                    $newSingleIconPath = Storage::disk('public')
                        ->putFileAs('icons', $uploadedIcon, $fileName);

                    $newData['icon'] = $newSingleIconPath;
                } elseif (Arr::get($data, 'remove_file')) {
                    // Delete requested file
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }

                    $newData['icon'] = null;
                }

                // Cleanup icon values
                if (empty($newData['remove_file']) && !$newSingleIconPath) {
                    $newData['icon'] = $oldIconPath ?? null;
                }

                unset($newData['remove_file']);

                // ---- UPDATE ----
                $updated = $this->interface->update($id, $newData);

                if (!$updated) {
                    Log::error('Failed to update category', [
                        'category_id' => $id,
                        'new_data' => $newData
                    ]);

                    throw new \Exception('Failed to update category');
                }

                $freshData = $findData->fresh();

                // ---- RE-TRANSLATE IF NAME CHANGED ----
                if ($nameChanged) {
                    Log::info('Category name changed, dispatching translation job', [
                        'category_id' => $id,
                        'old_name' => $oldData['name'],
                        'new_name' => $newData['name']
                    ]);

                    $freshData->dispatchTranslation(
                        defaultLanguageLocale: 'en',
                        targetLanguageIds: null
                    );
                }

                return $freshData;
            });
        } catch (\Throwable $e) {
            Log::error('Category update failed', [
                'category_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }
}
