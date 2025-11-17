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
        return [
            'sort_order' => $faker->numberBetween(1, 1000),
            'name' => $name = ucfirst($faker->unique()->word()),
            'slug' => Str::slug($name . '-' . $faker->unique()->word()),
            'description' => $faker->sentence(),
            'meta_title' => $faker->sentence(3),
            'meta_description' => $faker->paragraph(),
            'icon' => null,
            'is_featured' => $faker->boolean(),
            'status' => CategoryStatus::ACTIVE->value,

            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => null,
            'restored_by' => null,
            'restored_at' => null,

            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
