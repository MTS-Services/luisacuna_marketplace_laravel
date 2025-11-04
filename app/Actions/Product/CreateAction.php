<?php

namespace App\Actions\Product;


use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    ) {}

    public function execute(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $images = $data['images'] ?? [];
            unset($data['images']);

            $product = $this->interface->create($data);

            if (!empty($images)) {
                $this->handleImages($product, $images);
            }

            return $product->fresh('images');
        });
    }

    protected function handleImages(Product $product, array $images): void
    {
        foreach ($images as $index => $image) {
            $imagePath = $image->store('products/images', 'public');


            $product->images()->create([
                'image_path' => $imagePath,
                'thumbnail_path' => null,
                'is_primary' => $index === 0, 
                'sort_order' => $index,
                'creater_id' => $product->creater_id,
                'creater_type' => $product->creater_type,
            ]);
        }
    }
}
