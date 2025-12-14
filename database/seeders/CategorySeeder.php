<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Enums\CategoryStatus;

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
                'icon' => '',
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
                'icon' => '',
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
                'icon' => '',
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
                'icon' => '',
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
                'icon' => '',
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
                'icon' => '',
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
                'icon' => '',
                'status' => CategoryStatus::ACTIVE->value,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
