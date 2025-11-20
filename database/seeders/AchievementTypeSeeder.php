<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\AchievementType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AchievementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AchievementType::insert([
            [
                'sort_order' => 1,
                'name' => 'Gold Achievement',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'name' => 'Silver Achievement',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'name' => 'Bronze Achievement',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
