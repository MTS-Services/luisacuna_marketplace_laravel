<?php

namespace App\Actions\Rank;

use App\Models\Rank;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\RankRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{

    public function __construct(protected RankRepositoryInterface $interface) {}


    // public function execute(int $id, array $data): Rank
    // {
    // return DB::transaction(function () use ($id, $data) {
    //     $findData = $this->interface->find($id);
    //     if (!$findData) {
    //         Log::error('Data not found', ['data_id' => $id]);
    //         throw new \Exception('Data not found');
    //     }
    //     $updated = $this->interface->update($id, $data);
    //     if (!$updated) {
    //         Log::error('Failed to update data in repository', ['data_id' => $id]);
    //         throw new \Exception('Failed to update data');
    //     }
    //     return $findData->fresh();
    // });
    // }


    public function execute(int $id,  array $data): Rank
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find($id);

            if (!$model) {
                Log::error('Data not found', ['rank_id' => $id]);
                throw new \Exception('rank not found');
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

                $newSingleAvatarPath = Storage::disk('public')->putFileAs('ranks', $uploadedAvatar, $fileName);
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
                Log::error('Failed to update Data in repository', ['rank_id' => $id]);
                throw new \Exception('Failed to update rank');
            }

            // Refresh the rank model
            $model = $model->fresh();

            return $model;
        });
    }
}
