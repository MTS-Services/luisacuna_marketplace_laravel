<?php

namespace Database\Factories;

use App\Enums\GameServerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameServer>
 */
class GameServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => $this->faker->unique()->name(),
            // 'region' => $this->faker->randomElement(['Asia', 'Europe', 'US', 'Africa']),
            // 'type'   => $this->faker->randomElement(['Free', 'Paid', 'Premium']),
            'status' => $this->faker->randomElement(GameServerStatus::cases()),
        ];
    }
}
