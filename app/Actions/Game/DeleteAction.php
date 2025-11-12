<?php

namespace App\Actions\Game;

use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class   DeleteAction
{

    public function __construct(protected GameRepositoryInterface $interface) {}

    public function execute($id,bool $forceDelete = false, ?int $actionerId = null): bool
    {
     return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            $isDeleted = false;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }

            if ($forceDelete) {
                
                $isDeleted = $this->interface->forceDelete($id);

                if ($isDeleted) {

                    $old = $findData->logo;

                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }

                    $old = $findData->banner;
                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }
                    
                    $old = $findData->thumbnail;
                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }
                    return true;
                }

                return $isDeleted;

            }
                
            return $this->interface->delete($id, $actionerId);
        });

    }
}
