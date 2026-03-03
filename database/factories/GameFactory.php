<?php

namespace Database\Factories;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\GamePlatform;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Game::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'sort_order' => fake()->numberBetween(1, 1000),
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->randomNumber(5)),
            'description' => fake()->sentence(),
            'status' => GameStatus::ACTIVE->value,
        ];
    }
}
