<?php

namespace Database\Seeders;

use App\Enums\ActiveInactiveEnum;
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
        $users = User::pluck('id');
        $platformIds = Platform::pluck('id');
        $targetGameId = Game::value('id');

        $targetCategories = [1, 2, 3];
        $productsPerCategory = 5;

        if ($users->isEmpty() || $platformIds->isEmpty() || !$targetGameId) {
            return;
        }

        $staticProductData = [
            [
                'name' => '1000 Gold Coins Package',
                'description' => 'A large supply of in-game gold for immediate use. Delivered instantly to your account.',
                'price' => 19.99,
                'quantity' => 500,
                'delivery_timeline' => 'Instant Delivery',
            ],
            [
                'name' => 'Starter Legendary Item Crate',
                'description' => 'Guaranteed rare item drop. Perfect for new players looking for a competitive edge.',
                'price' => 49.50,
                'quantity' => 150,
                'delivery_timeline' => '1 Hour Delivery',
            ],
            [
                'name' => 'Level 60 Account (Warrior Class)',
                'description' => 'Pre-leveled account ready for endgame content. Full access provided within 24 hours.',
                'price' => 149.00,
                'quantity' => 10,
                'delivery_timeline' => '24 Hour Delivery',
            ],
            [
                'name' => 'Weekend EXP Boosting Service',
                'description' => 'Our professional boosters will log in and boost your character\'s experience over the weekend.',
                'price' => 75.00,
                'quantity' => 50,
                'delivery_timeline' => '3 Day Delivery',
            ],
            [
                'name' => 'Premium Mount Token',
                'description' => 'Redeemable for any premium mount in the game store. Limited stock available.',
                'price' => 29.99,
                'quantity' => 300,
                'delivery_timeline' => 'Instant Delivery',
            ],
        ];

        $seedCategoryProducts = function (int $categoryId, int $gameId) use ($users, $platformIds, $productsPerCategory, $staticProductData) {

            $gameConfigs = GameConfig::where('game_category_id', $categoryId)
                ->where('game_id', $gameId)
                ->get();

            if ($gameConfigs->isEmpty()) {
                return;
            }

            for ($i = 0; $i < $productsPerCategory; $i++) {

                $data = $staticProductData[$i % count($staticProductData)];

                $product = Product::create([
                    'category_id' => $categoryId,
                    'game_id'     => $gameId,
                    'user_id'     => $users->random(),
                    'name'        => $data['name'] . " - Cat {$categoryId}",
                    'description' => $data['description'],
                    'delivery_timeline' => $data['delivery_timeline'],
                    'price'       => $data['price'] + ($categoryId * 0.50),
                    'quantity'    => $data['quantity'] + ($i * 10),
                    'platform_id' => $platformIds->random(),
                    'status'      => ActiveInactiveEnum::ACTIVE->value,
                    'created_at'  => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at'  => Carbon::now(),
                ]);

                foreach ($gameConfigs as $gameConfig) {
                    ProductConfig::create([
                        'product_id'     => $product->id,
                        'game_config_id' => $gameConfig->id,
                        'category_id'    => $categoryId,
                        'value'          => $gameConfig->value,
                        'created_at'     => Carbon::now(),
                        'updated_at'     => Carbon::now(),
                    ]);
                }
            }
        };

        foreach ($targetCategories as $categoryId) {
            $seedCategoryProducts($categoryId, $targetGameId);
        }
    }
}
