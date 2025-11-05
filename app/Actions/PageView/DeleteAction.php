<?php

namespace App\Actions\PageView;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\PageViewRepositoryInterface;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PageViewRepositoryInterface $interface
    ) {}


    public function execute(int $id, bool $forceDelete = false, int $actionerId)
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $product = null;

            if ($forceDelete) {
                $product = $this->interface->findTrashed($id);
            } else {
                $product = $this->interface->find($id);
            }

            if (!$product) {
                throw new \Exception('Product not found');
            }



            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
