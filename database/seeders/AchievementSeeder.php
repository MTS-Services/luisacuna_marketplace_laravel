<?php

namespace Database\Seeders;

use App\Enums\AchievementStatus;
use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::factory()->count(40)->create();
    }
}
