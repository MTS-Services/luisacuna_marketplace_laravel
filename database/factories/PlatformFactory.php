<?php

namespace Database\Factories;

use App\Enums\PlatformStatus;
use App\Models\Admin;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GamePlatform>
 */
class PlatformFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Platform::class;
    public function definition(): array
    {
        $faker = Faker::create();
        $name = substr($faker->unique()->name(), 0, 10);
        return [
            'name' => fake()->name(),
            'status' => fake()->randomElement(PlatformStatus::cases()),
            'created_by' => Admin::inRandomorder()->value('id'),
        ];
    }
}
