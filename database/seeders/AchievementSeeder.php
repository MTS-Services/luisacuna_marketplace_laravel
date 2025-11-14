<?php

namespace Database\Seeders;

use App\Enums\AchievementStatus;
use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::insert([
            [
                'sort_order'   => 1,
                'rank_id'      => 1,
                'icon'         => 'icons/achievement1.png',
                'title'        => 'First Achievement',
                'description'  => 'This is the first sample achievement.',
                'category_id'  => 1,
                'target_value' => 100,
                'point_reward' => 50,
                'status'       => AchievementStatus::ACTIVE->value,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'sort_order'   => 2,
                'rank_id'      => 1,
                'icon'         => 'icons/achievement2.png',
                'title'        => 'Pro Level Achievement',
                'description'  => 'This is the second sample achievement.',
                'category_id'  => 1,
                'target_value' => 200,
                'point_reward' => 100,
                'status'       => AchievementStatus::ACTIVE->value,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'sort_order'   => 3,
                'rank_id'      => 1,
                'icon'         => null,
                'title'        => 'Beginner Milestone',
                'description'  => 'Achievement for beginners.',
                'category_id'  => 1,
                'target_value' => 50,
                'point_reward' => 25,
                'status'       => AchievementStatus::ACTIVE->value,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);
    }
}
