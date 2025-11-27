<?php

namespace Database\Seeders;

use App\Models\GameFeature;
use Illuminate\Database\Seeder;

class GameFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        GameFeature::factory(10)->create();
    }
}
