<?php

namespace Database\Factories;

use App\Enums\GamePlatformStatus;
use App\Models\Admin;
use App\Models\GamePlatform;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GamePlatform>
 */
class GamePlatformFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model =  GamePlatform::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->unique()->slug(),
            'status' => fake()->randomElement(GamePlatformStatus::cases()),
            'created_by' => Admin::inRandomorder()->value('id'),
        ];
    }
}
