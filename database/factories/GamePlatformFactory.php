<?php

namespace Database\Factories;

use App\Enums\GamePlatformStatus;
use App\Models\Admin;
use App\Models\GamePlatform;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
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
        $faker = Faker::create();
        $name =substr($faker->unique()->name(),0,3);
        return [
            // 
            'name' => $name,
            'slug' => Str::slug($name),
            'status' => fake()->randomElement(GamePlatformStatus::cases()),
            'created_by' => Admin::inRandomorder()->value('id'),
        ];
    }
}
