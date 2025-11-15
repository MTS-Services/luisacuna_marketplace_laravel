<?php

namespace Database\Seeders;

use App\Enums\AchievementStatus;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\Rank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $facker = Faker::create();
        $ranks = Rank::all();
        $categories = Category::all();
        for ($i = 1; $i <= $ranks->count(); $i++) {
            for ($j = 1; $j <= $categories->count(); $j++) {
                Achievement::create([
                    "rank_id" => $i,
                    "title" => $facker->name(),
                    "description" => $facker->sentence(15),
                    "category_id" => $j,
                    "target_value" => rand(1, 100),
                    "point_reward" => rand(50, 200),
                ]);
            }
        }
    }
}
