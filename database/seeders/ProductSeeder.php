<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Enums\ProductStatus;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Enums\ProductsVisibility;
use Illuminate\Support\Facades\DB;
use App\Enums\ProductsDeliveryMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {
            $title = $faker->sentence(3);
            $price = $faker->randomFloat(2, 5, 200);

            DB::table('products')->insert([
                'sort_order' => $i,
                'seller_id' => rand(1, 5),
                'game_id' => 1,
                'product_type_id' => 1,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'description' => $faker->paragraph(),
                'price' => $price,
                'currency_id' => 1,
                'discount_percentage' => rand(0, 50),
                'discounted_price' => null,
                'stock_quantity' => rand(1, 100),
                'min_purchase_quantity' => 1,
                'max_purchase_quantity' => rand(2, 10),
                'unlimited_stock' => $faker->boolean(10),
                'delivery_method' => ProductsDeliveryMethod::MANUAL,
                'delivery_time_hours' => rand(12, 72),
                'auto_delivery_content' => $faker->paragraph(),
                'server_id' => rand(1, 5),
                'platform' => $faker->randomElement(['PC', 'PS5', 'Xbox', 'Switch']),
                'region' => $faker->country(),
                'specifications' => json_encode(['CPU' => 'Intel i5', 'RAM' => '8GB']),
                'requirements' => json_encode(['OS' => 'Windows 10']),
                'status' => ProductStatus::PENDING_REVIEW,
                'is_featured' => $faker->boolean(20),
                'is_hot_deal' => $faker->boolean(10),
                'visibility' => ProductsVisibility::PUBLIC,
                'total_sales' => rand(0, 100),
                'total_revenue' => 0,
                'view_count' => rand(0, 500),
                'favorite_count' => rand(0, 100),
                'average_rating' => $faker->randomFloat(2, 0, 5),
                'total_reviews' => rand(0, 50),
                'reviewed_by' => rand(1, 5),
                'reviewed_at' => Carbon::now(),
                'rejection_reason' => null,
                'meta_title' => $faker->sentence(),
                'meta_description' => $faker->paragraph(),
                'meta_keywords' => implode(', ', $faker->words(5)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
