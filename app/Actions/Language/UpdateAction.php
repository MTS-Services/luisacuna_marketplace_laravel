<?php

namespace App\Actions\Language;

use App\Models\Language;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class UpdateAction
{
    public function __construct(
        protected LanguageRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): Language
    {
        return DB::transaction(function () use ($id, $data) {

            // Fetch Language
            $findData = $this->interface->find($id);

            if (!$findData) {
                Log::error('Data not found', ['language_id' => $id]);
                throw new \Exception('Language not found');
            }

            // --- 1. CSV Handling ---
            $oldFilePath = $findData->file ?? null;

            $uploadedFile = Arr::get($data, 'file');

            if ($uploadedFile instanceof \Illuminate\Http\UploadedFile) {
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }

                $sanitizedName = strtolower(str_replace(' ', '_', $data['locale']));
                $prefix = $sanitizedName . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedFile->getClientOriginalName();

                $filePath = Storage::disk('public')->putFileAs('languages', $uploadedFile, $fileName);

                $data['file'] = $filePath;
            } elseif (Arr::get($data, 'remove_file')) {
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
                $data['file'] = null;
            } else {
                $data['file'] = $oldFilePath ?? null;
            }

            unset($data['remove_file']);


            $oldData = $findData->getAttributes();

            // Update Language
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Data', ['language_id' => $id]);
                throw new \Exception('Failed to update Data');
            }

            // Refresh model
            $findData = $findData->fresh();

            // Detect changes
            $changes = [];
            foreach ($findData->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            return $findData;
        });
    }
}
