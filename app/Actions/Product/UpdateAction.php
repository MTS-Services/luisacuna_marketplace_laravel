<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;


class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductTypeRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            // fatch Product Type
            $productType = $this->interface->find($id);

            if (!$productType) {
                Log::error('Product Type not found', ['product_type_id' => $id]);
                throw new \Exception('Product Type not found');
            }

            $oldData = $productType->getAttributes();

            // Update Product Type
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Product Type', ['product_type_id' => $id]);
                throw new \Exception('Failed to update Product Type');
            }

            // Refresh model
            $productType = $productType->fresh();

            // Detect changes
            $changes = [];
            foreach ($productType->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'from' => $oldData[$key],
                        'to' => $value,
                    ];
                }
            }
            return [$productType, $changes];
        });
    }
}
