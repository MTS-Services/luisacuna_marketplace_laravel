<?php

namespace App\Actions\Rarity;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RarityRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{

    public function __construct(protected RarityRepositoryInterface $interface)
    {
    }



    public function execute(int $id, bool $forceDelete = false, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }
            if ($forceDelete) {
                // Delete avatar
                if ($findData->icon && Storage::disk('public')->exists($findData->icon)) {
                    Storage::disk('public')->delete($findData->icon);
                }
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
