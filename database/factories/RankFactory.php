<?php

namespace Database\Factories;

use App\Enums\RankStatus;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rank>
 */
class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $name =substr($faker->unique()->name(),0,10);
        return [
            //
            'name'  => $name,
            'slug'  => Str::slug($name),
            'status' => fake()->randomElement(RankStatus::cases()),
            'minimum_points' => $faker->numberBetween(500, 1000),
            'created_by' => Admin::inRandomorder()->value('id'),
            'icon' => $faker->imageUrl(200, 200),

        ];
    }
}
