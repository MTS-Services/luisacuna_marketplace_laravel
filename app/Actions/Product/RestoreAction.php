<?php

namespace App\Actions\Product;

use App\Repositories\Contracts\ProductRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    )
    {}

    public function execute(int $id, int $actionerId)
    {
        return $this->interface->restore($id, $actionerId);
    }
}
