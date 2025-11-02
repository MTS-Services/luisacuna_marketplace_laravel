<?php

namespace App\Actions\Product;

use App\Models\ProductType;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected ProductTypeRepositoryInterface $interface
    ) {}

    public function execute(array $data): ProductType
    {
       return DB::transaction(function () use ($data) {
            $productType = $this->interface->create($data);
            return $productType->fresh();
        });
    }
}