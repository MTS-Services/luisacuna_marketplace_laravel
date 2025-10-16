<?php

namespace Database\Factories;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameCategory>
 */
class GameCategoryFactory extends Factory
{
       protected  $model = GameCategory::class;

       
    public function definition(): array
    {
            $faker = Faker::create();
            return [
                    'sort_order' => $faker->numberBetween(1, 1000),
                    'name' => $name = ucfirst($faker->word()),
                    'slug' => Str::slug($name),



                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,

                    'creater_id' => 1,
                    'updater_id' => 1,
                    'deleter_id' => null,
                    'status' => GameCategoryStatus::ACTIVE->value,
        ];
    }
}
