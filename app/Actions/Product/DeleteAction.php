<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductTypeRepositoryInterface $interface
    )
    {}

    public function execute(int $id, bool $forceDelete = false, int $actionerId)
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $productType = null;

            if ($forceDelete) {
                $productType = $this->interface->findTrashed($id);
            } else {
                $productType = $this->interface->find($id);
            }

            if (!$productType) {
                throw new \Exception('Product Type not found');
            }


            
            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
