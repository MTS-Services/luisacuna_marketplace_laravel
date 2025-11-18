<?php

namespace Database\Factories;

use App\Enums\ServerStatus;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameServer>
 */
class ServerFactory extends Factory
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
            'status' => $this->faker->randomElement(ServerStatus::cases()),
             'created_by' => Admin::inRandomorder()->value('id'),
        ];
    }
}
