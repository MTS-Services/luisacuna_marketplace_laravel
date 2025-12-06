<?php

namespace Database\Factories;

use App\Enums\PlatformStatus;
use App\Models\Admin;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GamePlatform>
 */
class PlatformFactory extends Factory
{
    protected $model = Platform::class;

    public function definition(): array
    {
        // Use the built-in faker instance
        $name = substr($this->faker->unique()->name(), 0, 10);

        return [
            'name'       => $name,
            'status'     => $this->faker->randomElement(PlatformStatus::cases()),
            'created_by' => Admin::inRandomOrder()->value('id'),
        ];
    }
}
