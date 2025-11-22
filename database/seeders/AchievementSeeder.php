<?php

namespace Database\Seeders;

use App\Models\Rank;
use App\Models\Category;
use App\Models\Achievement;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Enums\AchievementStatus;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        // $facker = Faker::create();
        // $ranks = Rank::all();
        // $categories = Category::all();
        // for ($i = 1; $i <= $ranks->count(); $i++) {
        //     for ($j = 1; $j <= $categories->count(); $j++) {
        //         Achievement::create([
        //             "rank_id" => $i,
        //             "title" => $facker->name(),
        //             "description" => $facker->sentence(15),
        //             "category_id" => $j,
        //             "target_value" => rand(1, 100),
        //             "point_reward" => rand(50, 200),
        //         ]);
        //     }
        // }


        Achievement::insert([
            [
                'sort_order' => 1,
                'achievement_type_id' => 1, // Must exist in achievement_types
                'rank_id' => 1,             // Must exist in ranks table
                'icon' => 'icon-gold.png',
                'title' => 'Gold Star Performer',
                'description' => 'Awarded for achieving outstanding performance.',
                'target_value' => 100,
                'point_reward' => 500,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'achievement_type_id' => 2,
                'rank_id' => 1,
                'icon' => 'icon-silver.png',
                'title' => 'Silver Achiever',
                'description' => 'Awarded for consistent improvement.',
                'target_value' => 50,
                'point_reward' => 300,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'achievement_type_id' => 3,
                'rank_id' => 2,
                'icon' => 'icon-bronze.png',
                'title' => 'Bronze Contributor',
                'description' => 'Awarded for completing initial milestones.',
                'target_value' => 20,
                'point_reward' => 100,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
