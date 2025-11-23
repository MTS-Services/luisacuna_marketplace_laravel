<?php

namespace App\Actions\Platform;

use App\Events\Platform\PlatformUpdated;
use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class UpdateAction
{
    public function __construct(protected PlatformRepositoryInterface $interface) {}

    public function execute(int $id, array $data): Platform
    {
        $newSingleIconPath = null;

        try {
            return DB::transaction(function () use ($id, $data, &$newSingleIconPath) {

                $findData = $this->interface->find($id);

                if (!$findData) {
                    Log::error('Platform not found', ['platform_id' => $id]);
                    throw new Exception('Platform not found');
                }

                $oldData = $findData->getAttributes();
                $newData = $data;

                // --- SINGLE ICON HANDLING ---
                $oldIconPath = Arr::get($oldData, 'icon');
                $uploadedIcon = Arr::get($data, 'icon');

                // Upload new file
                if ($uploadedIcon instanceof UploadedFile) {

                    // Delete old file if exists
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }

                    // Store new file
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedIcon->getClientOriginalName();

                    $newSingleIconPath = Storage::disk('public')
                        ->putFileAs('platforms', $uploadedIcon, $fileName);

                    $newData['icon'] = $newSingleIconPath;
                }

                // Remove file requested
                elseif (Arr::get($data, 'remove_file')) {
                    if ($oldIconPath && Storage::disk('public')->exists($oldIconPath)) {
                        Storage::disk('public')->delete($oldIconPath);
                    }

                    $newData['icon'] = null;
                }

                // No file change → keep old file
                else {
                    $newData['icon'] = $oldIconPath;
                }

                unset($newData['remove_file']);

                // Update database
                $this->interface->update($id, $newData);

                // Trigger change event
                $changes = array_diff_assoc($newData, $oldData);
                if (!empty($changes)) {
                    event(new PlatformUpdated($findData, $changes));
                }

                return $findData->fresh();
            });
        } catch (Exception $e) {

            // Rollback uploaded new file if transaction fails
            if ($newSingleIconPath && Storage::disk('public')->exists($newSingleIconPath)) {
                Storage::disk('public')->delete($newSingleIconPath);
            }

            // Log the full error details
            Log::error('Platform update failed', [
                'platform_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw exception so controller can handle
            throw $e;
        }
    }
}
