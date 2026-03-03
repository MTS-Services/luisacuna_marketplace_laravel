<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameCategory>
 */
class CategoryFactory extends Factory
{
    protected  $model = Category::class;


    public function definition(): array
    {
        $faker = Faker::create();
        $name = ucfirst($faker->unique()->word());

        return [
            'sort_order' => $faker->numberBetween(1, 1000),
            'name' => $name,
            'slug' => Str::slug($name . '-' . $faker->unique()->word()),
            'icon' => null,
            'status' => CategoryStatus::ACTIVE->value,
            'layout' => 'list_grid',
            'meta_title' => $faker->sentence(3),
            'meta_description' => $faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
