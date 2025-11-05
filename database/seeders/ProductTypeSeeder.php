<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;
use App\Enums\ProductTypeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::insert([
            [
                'sort_order' => 1,
                'name' => 'Game Boosting',
                'slug' => 'game-boosting',
                'description' => 'Boosting services for various games.',
                'icon' => 'boosting.png',
                'requires_delivery_time' => true,
                'requires_server_info' => true,
                'requires_character_info' => true,
                'max_delivery_time_hours' => 48,
                'commission_rate' => 10.00,
                'status' => ProductTypeStatus::ACTIVE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 2,
                'name' => 'Gift Cards',
                'slug' => 'gift-cards',
                'description' => 'Digital gift cards for various platforms.',
                'icon' => 'giftcard.png',
                'requires_delivery_time' => false,
                'requires_server_info' => false,
                'requires_character_info' => false,
                'max_delivery_time_hours' => 24,
                'commission_rate' => 5.00,
                'status' => ProductTypeStatus::ACTIVE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 3,
                'name' => 'Accounts',
                'slug' => 'accounts',
                'description' => 'Pre-made gaming accounts for sale.',
                'icon' => 'accounts.png',
                'requires_delivery_time' => true,
                'requires_server_info' => true,
                'requires_character_info' => false,
                'max_delivery_time_hours' => 72,
                'commission_rate' => 8.00,
                'status' => ProductTypeStatus::ACTIVE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
