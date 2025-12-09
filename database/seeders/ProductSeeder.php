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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

  
        for ($i = 0; $i < 5; $i++) {

              //    Categoyr 1 Products
            $product = Product::create([
                'category_id' => 1,
                'game_id'     => 1, // important
                'user_id'     => $users->random()->id,
                'name'        => fake()->name(),
                'description' => fake()->text(),
                'delivery_timeline' => 'Instant Delivery',
                'price'       => fake()->randomFloat(2, 0, 100),
                'quantity'    => fake()->randomNumber(4),
                'platform_id' => Platform::inRandomOrder()->value('id'),
                'status'      => ActiveInactiveEnum::ACTIVE->value,
            ]);
            $gameConfigs = GameConfig::where('game_category_id', 1)
                            ->where('game_id', 1)
                            ->get();
            foreach ($gameConfigs as $gameConfig) {
                ProductConfig::create([
                    'product_id' => $product->id,
                    'game_config_id' => $gameConfig->id,
                    'category_id' => 1,
                    'value' => $gameConfig->value,
                ]);
            }
            

              //    Categoyr 2 Products
            $product = Product::create([
                'category_id' => 2,
                'game_id'     => 1, // important
                'user_id'     => $users->random()->id,
                'delivery_timeline' => 'Instant Delivery',
                'name'        => fake()->name(),
                'description' => fake()->text(),
                'price'       => fake()->randomFloat(2, 0, 100),
                'quantity'    => fake()->randomNumber(4),
                'platform_id' => Platform::inRandomOrder()->value('id'),
                'status'      => ActiveInactiveEnum::ACTIVE->value,
            ]);
            $gameConfigs = GameConfig::where('game_category_id', 2)
                            ->where('game_id', 1)
                            ->get();
            foreach ($gameConfigs as $gameConfig) {
                ProductConfig::create([
                    'product_id' => $product->id,
                    'game_config_id' => $gameConfig->id,
                    'category_id' => 1,
                    'value' => $gameConfig->value,
                ]);
            }

              //    Categoyr 3 Products
            $product = Product::create([
                'category_id' => 3,
                'game_id'     => 1, // important
                'user_id'     => $users->random()->id,
                'delivery_timeline' => 'Instant Delivery',
                'name'        => fake()->name(),
                'description' => fake()->text(),
                'price'       => fake()->randomFloat(2, 0, 100),
                'quantity'    => fake()->randomNumber(4),
                'platform_id' => Platform::inRandomOrder()->value('id'),
                'status'      => ActiveInactiveEnum::ACTIVE->value,
            ]);
            $gameConfigs = GameConfig::where('game_category_id', 3)
                            ->where('game_id', 1)
                            ->get();
            foreach ($gameConfigs as $gameConfig) {
                ProductConfig::create([
                    'product_id' => $product->id,
                    'game_config_id' => $gameConfig->id,
                    'category_id' => 1,
                    'value' => $gameConfig->value,
                ]);
            }
            
        }
    
      
    }
}
