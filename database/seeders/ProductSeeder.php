<?php

namespace Database\Seeders;

use App\Enums\ActiveInactiveEnum;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameConfig;
use App\Models\Platform;
use App\Models\Product;
use App\Models\ProductConfig;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $games = Game::all();
        $platforms = Platform::pluck('id');
        $users = User::pluck('id');
        $categories = Category::all();
        $productsPerCategory = 50;

        $deliveryItems = ['Instant Delivery', '1 Hour Delivery', '3 Day Delivery', '24 Hour Delivery', '7 Day Delivery', '30 Day Delivery'];

        foreach ($categories as $category) {
            foreach ($games as $game) {
                $gameConfigs = GameConfig::where('game_category_id', $category->id)
                    ->where('game_id', $game->id)
                    ->get();

                if ($gameConfigs->isEmpty()) {
                    continue;
                }

                for ($i = 0; $i < $productsPerCategory; $i++) {
                    $product = Product::create([
                        'category_id' => $category->id,
                        'game_id'     => $game->id,
                        'user_id'     => $users->random(),
                        'name'        => $game->name . ' - ' . $category->name,
                        'description' => $game->description,
                        'delivery_timeline' => $deliveryItems[$i % count($deliveryItems)],
                        'price'       => (($i * 10) + rand(1, 100)),
                        'quantity'    => $i * 10,
                        'platform_id' => $platforms->random(),
                        'status'      => ActiveInactiveEnum::ACTIVE->value,
                    ]);

                    foreach ($gameConfigs as $gameConfig) {
                        ProductConfig::create([
                            'product_id'     => $product->id,
                            'game_config_id' => $gameConfig->id,
                            'category_id'    => $category->id,
                            'value'          => $gameConfig->value,
                        ]);
                    }
                }
            }
        }
    }
}
