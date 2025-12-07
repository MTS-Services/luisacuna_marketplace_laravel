<?php

namespace Database\Seeders;

use App\Enums\ActiveInactiveEnum;
use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();
        $games = Game::all();

        $products = [];

        foreach ($categories as $category) {
            foreach ($users as $user) {
                $products[] = [
                    'category_id' => $category->id,
                    'game_id' => $games->random()->id,
                    'user_id' => $user->id,
                    // 'name' => fake()->name(),
                    // 'slug' => fake()->slug() . '-' . time() . rand(1, 100),
                    'description' => fake()->text(),
                    'price' => fake()->randomFloat(2, 0, 100),
                    'quantity' => fake()->randomNumber(2),
                    'platform_id'=>Platform::inRandomOrder()->value('id'),
                    // 'minimum_offer_quantity' => fake()->randomNumber(2),
                    // 'delivery_method' => fake()->randomElement(['instent', 'in-game-delivery']),
                    // 'delivery_time' => fake()->randomElement(['1 hour', '1 day', '2 days', '3 days', '5 days', '7 days', '10 days']),
                    'status' => ActiveInactiveEnum::ACTIVE->value,
                ];
            }
        }

        // Product::insert($products);
    }
}
