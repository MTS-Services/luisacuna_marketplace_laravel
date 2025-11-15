<?php

namespace Database\Factories;

use App\Models\OfferItem;
use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferItemFactory extends Factory
{
    protected $model = OfferItem::class;

    public function definition(): array
    {
        return [
            'sort_order' => $this->faker->numberBetween(0, 10),

            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(500, 500, 'product'),

            'delivery_time' => $this->faker->dateTimeBetween('+1 day', '+7 days'),
            'delivery_method_id' => DeliveryMethod::factory(), // auto creates delivery method

            'quantity' => $this->faker->numberBetween(1, 10),
            'terms_condition' => $this->faker->boolean(),
            'agreement' => $this->faker->boolean(),

            'price' => $this->faker->randomFloat(2, 10, 999),
        ];
    }
}
