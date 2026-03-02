<?php

namespace App\Actions\PageView;

use App\Repositories\Contracts\PageViewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PageViewRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete, int $actionerId)
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $product = null;

            if ($forceDelete) {
                $product = $this->interface->findTrashed($id);
            } else {
                $product = $this->interface->find($id);
            }

            if (! $product) {
                throw new \Exception(__('Product not found'));
            }

            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }
}
