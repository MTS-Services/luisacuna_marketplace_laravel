<?php

namespace Database\Factories;

use App\Enums\ActiveInactiveEnum;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'sort_order' => fake()->numberBetween(1, 1000),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 500),
            'quantity' => fake()->numberBetween(1, 100),
            'status' => ActiveInactiveEnum::ACTIVE->value,
            'delivery_timeline' => 'instant',
            'delivery_method' => 'automatic',
            'sales_count_30d' => 0,
            'average_rating' => 0,
            'is_top_selling' => false,
        ];
    }

    public function topSelling(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_top_selling' => true,
        ]);
    }
}
