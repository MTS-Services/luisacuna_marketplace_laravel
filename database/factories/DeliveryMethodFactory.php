<?php

namespace Database\Factories;

use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryMethod>
 */
class DeliveryMethodFactory extends Factory
{
    protected $model = DeliveryMethod::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Door Delivery',
            'Express Delivery',
            'Pickup Point',
            'Courier Service',
            'Same Day Delivery'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(400, 400, 'delivery'),
            'status' => 'active', // or DeliveryMethodStatus::ACTIVE if enum

            'created_by' => 1,    // replace with actual admin ID
        ];
    }
}


