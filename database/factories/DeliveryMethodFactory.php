<?php

namespace Database\Factories;

use App\Enums\DeliveryMethodStatus;
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
        $name = $this->faker->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name)->unique(),
            'image' => 'https://placehold.co/400x400',
            'status' => DeliveryMethodStatus::ACTIVE->value,

            'created_by' => 1,
        ];
    }
}


