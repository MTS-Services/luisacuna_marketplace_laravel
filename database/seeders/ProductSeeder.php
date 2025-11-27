<?php

namespace Database\Seeders;

use App\Enums\ActiveInactiveEnum;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Product;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $platforms = Platform::all();
        $servers = Server::all();

        $products = [];

        foreach ($categories as $category) {
            foreach ($users as $user) {
                $products[] = [
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'platform_id' => $platforms->isNotEmpty() ? $platforms->random()->id : null,
                    'server_id' => $servers->isNotEmpty() ? $servers->random()->id : null,
                    'name' => fake()->name(),
                    'slug' => fake()->slug() . '-' . time() . rand(1, 100),
                    'description' => fake()->text(),
                    'price' => fake()->randomFloat(2, 0, 100),
                    'quantity' => fake()->randomNumber(2),
                    'minimum_offer_quantity' => fake()->randomNumber(2),
                    'delivery_method' => fake()->randomElement(['instent', 'in-game-delivery']),
                    'delivery_time' => fake()->randomElement(['1 hour', '1 day', '2 days', '3 days', '5 days', '7 days', '10 days']),
                    'status' => ActiveInactiveEnum::ACTIVE->value,
                ];
            }
        }

        Product::insert($products);
    }
}
