<?php

namespace Database\Factories;

use App\Enums\DeliveryMethodStatus;
use App\Models\Admin;
use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Factories\Factory;


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
            'slug' => $this->faker->unique->slug(),
            'image' => 'https://placehold.co/400x400',
            'status' => DeliveryMethodStatus::ACTIVE->value,
           'created_by' => Admin::inRandomorder()->value('id'),
        ];
    }
}


