<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "rank_id" => Rank::inRandomOrder()->value('id'),
            "title" => "Achievement Title",
            "description" => "Achievement Description",
            "category_id" => Category::inRandomOrder()->value('id'),
            "target_value" => rand(1, 100),
            "point_reward" => rand(50, 200),
        ];
    }
}
