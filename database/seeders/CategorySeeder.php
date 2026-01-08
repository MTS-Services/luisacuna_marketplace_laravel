<?php

namespace Database\Seeders;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'sort_order' => 1,
                'name' => 'Currency',
                'slug' => 'currency',
                'meta_title' => 'Robux',
                'meta_description' => 'Robux',
                'icon' => '17155284_fdzxvx',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 2,
                'name' => 'Gift Card',
                'slug' => 'gift-card',
                'meta_title' => 'Grow A Garden',
                'meta_description' => 'Grow A Garden',
                'icon' => 'images_2_xafprk',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 3,
                'name' => 'Boosting',
                'slug' => 'boosting',
                'meta_title' => 'boosting',
                'meta_description' => 'boosting',
                'icon' => '6106288_v43lr8',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'sort_order' => 4,
                'name' => 'Items',
                'slug' => 'items',
                'meta_title' => 'Hunty Zombie',
                'meta_description' => 'Hunty Zombie',
                'icon' => '8161879_u4xaky',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 5,
                'name' => 'Accounts',
                'slug' => 'accounts',
                'meta_title' => '99 Nights In The Forest',
                'meta_description' => '99 Nights In The Forest',
                'icon' => 'images_3_uirzjr',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 6,
                'name' => 'Top Up',
                'slug' => 'top-up',
                'meta_title' => 'Prospecting',
                'meta_description' => 'Prospecting',
                'icon' => '5894760_r5ptrc',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 7,
                'name' => 'Coaching',
                'slug' => 'coaching',
                'meta_title' => 'All Star Tower Defense X',
                'meta_description' => 'All Star Tower Defense X',
                'icon' => '13322748_s4nflz',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
