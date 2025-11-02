<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductType $model
    ) {}


    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }





    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function create(array $data): ProductType
    {
        return $this->model->create($data);
    }
}
