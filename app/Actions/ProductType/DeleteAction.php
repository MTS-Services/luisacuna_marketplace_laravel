<?php

namespace App\Actions\ProductType;

use App\Repositories\Contracts\ProductTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductTypeRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete, int $actionerId)
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (! $findData) {
                throw new \Exception(__('Data not found'));
            }

            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }
}
