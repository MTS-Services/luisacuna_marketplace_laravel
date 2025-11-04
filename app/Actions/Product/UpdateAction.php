<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\ProductRepositoryInterface;


class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    ) {}


    public function execute(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            // fatch Product 
            $product = $this->interface->find($id);

            if (!$product) {
                Log::error('Product not found', ['product_id' => $id]);
                throw new \Exception('Product not found');
            }
            $oldData = $product->getAttributes();

            // Update Product 
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Product', ['product_id' => $id]);
                throw new \Exception('Failed to update Product');
            }

            // Refresh model
            $product = $product->fresh();

            // Detect changes
            $changes = [];
            foreach ($product->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'from' => $oldData[$key],
                        'to' => $value,
                    ];
                }
            }
            return [$product, $changes];
        });
    }
}
