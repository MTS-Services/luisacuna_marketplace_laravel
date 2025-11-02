<?php

namespace App\Services\Product;

use App\Models\ProductType;
use App\Actions\Product\CreateAction;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;

class ProductTypeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductTypeRepositoryInterface $interface,
        protected CreateAction $createAction
    ) {}


    /* ================== ================== ==================
    *                          Find Methods 
    * ================== ================== ================== */
    public function getAll($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }



    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */
    public function createData(array $data): ProductType
    {
        return $this->createAction->execute($data);
    }
}
