<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Category;
use App\Models\Rank;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
               
                'icon' => 'download_i1fdsc',
                'title' => '3 Porduct Purchased',
                'description' => 'Awarded for achieving outstanding performance.',
                'target_value' => 3,
                'point_reward' => 300,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'achievement_type_id' => 2,
                
                'icon' => '17155284_fdzxvx',
                'title' => '5 Porduct Purchased',
                'description' => 'Awarded for consistent improvement.',
                'target_value' => 5,
                'point_reward' => 500,
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'achievement_type_id' => 3,
               
                'icon' => '11881945_xhkrcc',
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
