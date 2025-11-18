<?php

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected CategoryRepositoryInterface $interface
    ) {}

    public function execute($id, $forceDelete = false, ?int $actionerId = null)
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
                if($findData->icon && Storage::disk('public')->exists($findData->icon)) {

                    Storage::disk('public')->delete($findData->icon);

                }
                
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
