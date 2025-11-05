<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Favorite;
use App\Models\User;

use function PHPSTORM_META\type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'sort_order' => $this->faker->numberBetween(0, 10),
            'favorable_type' => 'type',
            'favorable_id'   => $this->faker->numberBetween(1,12),



                // audittableColumns





        ];
    }
}
