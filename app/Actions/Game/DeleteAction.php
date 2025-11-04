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
        return DB::transaction(function () use ($id, $forceDelete , $actionerId ) {

            if ($forceDelete) {

                $old_images = $this->interface->findTrashed($id)->getAttributes();

                $isDeleted =  $this->interface->forceDelete($id);

                if ($isDeleted) {

                    $old = $old_images['logo'];
                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }

                    $old = $old_images['banner'];
                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }

                    $old = $old_images['thumbnail'];
                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                    }

                    return true;
                }
                return false;
            }


            return $this->interface->delete($id, $actionerId);
        });
    }
}
