<?php

namespace App\Actions\Faq;


use App\Models\Faq;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\FaqRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class UpdateAction
{
    use WithNotification;

    public function __construct(protected FaqRepositoryInterface $interface)
    {
    }


    public function execute(int $id, array $data): Faq
    {
        $newSingleIconPath = null;

        try {
            return DB::transaction(function () use ($id, $data, &$newSingleIconPath) {

                $findData = $this->interface->find($id);

                if (!$findData) {
                    Log::error('Data not found', ['data_id' => $id]);
                    return;
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
                        ->putFileAs('rarity', $uploadedIcon, $fileName);

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

                $this->interface->update($id, $newData);
                return $findData->fresh();
            });
        } catch (Throwable $e) {
            if ($newSingleIconPath && Storage::disk('public')->exists($newSingleIconPath)) {
                Storage::disk('public')->delete($newSingleIconPath);
            }

            // Log the full error details
            Log::error('Data update failed', [
                'data_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

    }
}
