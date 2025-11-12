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
   protected $model =  Game::class;
    public function definition(): array
    {
        $faker = Faker::create();
        $name =$faker->unique()->name();
        return [
            'game_category_id' => GameCategory::inRandomOrder()->value('id'),
            'sort_order' => $faker->numberBetween(1, 1000),
            'name' => $name, 
            // 'platform' =>json_encode(array(GamePlatform::inRandomOrder()->value('id'))), 
            'slug' => Str::slug($name) ,            
            'description' => $faker->sentence(),            
            'status' => GameStatus::ACTIVE->value,  
        ];
    }
}
