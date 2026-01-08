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

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $games = Game::all();
        $platforms = Platform::pluck('id');
        $users = User::pluck('id');
        $categories = Category::all();
        $productsPerCategory = 1;

        $deliveryItems = ['Instant Delivery', '1 Hour Delivery', '3 Day Delivery', '24 Hour Delivery', '7 Day Delivery', '30 Day Delivery'];

        foreach ($categories as $category) {
            $this->command->info('Creating products for category: ' . $category->name);
            foreach ($games as $game) {
                $this->command->info('Creating products for game: ' . $game->name);

                for ($i = 0; $i < $productsPerCategory; $i++) {
                    $gameConfigs = GameConfig::where('game_category_id', $category->id)
                        ->where('game_id', $game->id)
                        ->get();

                    $product = Product::create([
                        'category_id' => $category->id,
                        'game_id'     => $game->id,
                        'user_id'     => $users->random(),
                        'name'        => $game->name . ' - ' . $category->name,
                        'description' => $game->description,
                        'delivery_timeline' => $deliveryItems[$i % count($deliveryItems)],
                        'price'       => (($i * 10) + rand(1, 100)),
                        'quantity'    => rand(500, 1000),
                        'platform_id' => $platforms->random(),
                        'status'      => ActiveInactiveEnum::ACTIVE->value,
                    ]);

                    if ($gameConfigs->isEmpty()) {
                        $this->command->warn('No game configs found for game: ' . $game->name);
                        continue;
                    }
                    foreach ($gameConfigs as $gameConfig) {
                        $this->command->info('Creating product config for game config: ' . $gameConfig->id);
                        ProductConfig::create([
                            'product_id'     => $product->id,
                            'game_config_id' => $gameConfig->id,
                            'category_id'    => $category->id,
                            'value'          => rand(1, 100),
                        ]);
                    }
                }
            }
        }
    }
}
