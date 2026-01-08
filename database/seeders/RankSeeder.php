<?php

namespace Database\Seeders;

use App\Enums\RankStatus;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        // Rank::factory()->count(5)->create();

        Rank::insert([
            [
                'sort_order' => 1,
                'name' => 'Bronze',
                'slug' => 'bronze',
                'minimum_points' => 0,
                'maximum_points' => 999,
                'icon' => 'images_5_ybuvyj',
                'status' => RankStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 2,
                'name' => 'Silver',
                'slug' => 'silver',
                'minimum_points' => 1000,
                'maximum_points' => 4999,
                'icon' => '17155284_1_yopz2t',
                'status' => RankStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 3,
                'name' => 'Gold',
                'slug' => 'gold',
                'minimum_points' => 5000,
                'maximum_points' => 9999,
                'icon' => '9590147_hka5mg',
                'status' => RankStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 4,
                'name' => 'Platinum',
                'slug' => 'platinum',
                'minimum_points' => 10000,
                'maximum_points' => 19999,
                'icon' => '16680510_gwtgjr',
                'status' => RankStatus::ACTIVE->value,
            ],
        ]);
    }
}
