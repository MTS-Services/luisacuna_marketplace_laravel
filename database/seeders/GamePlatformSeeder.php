<?php

namespace Database\Seeders;

use App\Models\GamePlatform;
use Illuminate\Database\Seeder;

class GamePlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        GamePlatform::factory(10)->create();
    }
}
