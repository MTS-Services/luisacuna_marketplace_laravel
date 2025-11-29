<?php

namespace App\Actions\Achievement;

use App\Models\Achievement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repositories\Contracts\AchievementRepositoryInterface;

class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementRepositoryInterface $interface
    )
    {}

        public function execute(int $id, array $data): Achievement
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find($id);

            if (!$model) {
                Log::error('Data not found', ['achievement_id' => $id]);
                throw new \Exception('achievement not found');
            }
            $oldData = $model->getAttributes();
            $newData = $data;

            $oldAvatarPath = Arr::get($oldData, 'icon');
            $uploadedAvatar = Arr::get($data, 'icon');
            $newSingleAvatarPath = null;

            if ($uploadedAvatar instanceof UploadedFile) {
                // Delete old icon permanently (icon deletion is non-reversible)
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }

                // Store the new icon and track path for rollback
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                $newSingleAvatarPath = Storage::disk('public')->putFileAs('achievements', $uploadedAvatar, $fileName);
                $newData['icon'] = $newSingleAvatarPath;
            } elseif (Arr::get($data, 'remove_icon')) {
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                $newData['icon'] = null;
            }

            if (!$newData['remove_icon'] && !$newSingleAvatarPath) {
                $newData['icon'] = $oldAvatarPath ?? null;
            }

            unset($newData['remove_icon']);


            // Update Admin
            $updated = $this->interface->update($id, $newData);

            if (!$updated) {
                Log::error('Failed to update Data in repository', ['achievement_id' => $id]);
                throw new \Exception('Failed to update achievement');
            }

            // Refresh the achievement model

            $titleChanged = isset($newData['title']) && $newData['title'] !== $oldData['title'];
            $descriptionChanged = isset($newData['description']) && $newData['description'] !== $oldData['description'];
            $freshData = $model->fresh();

            if($titleChanged || $descriptionChanged){
                $freshData->dispatchTranslation(
                    defaultLanguageLocale: 'en',
                    targetLanguageIds: null
                );
            }
            
            return $freshData;
        });
    }
}
