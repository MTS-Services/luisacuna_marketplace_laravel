<?php

namespace Database\Seeders;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
// use Faker\Factory as Faker;
class GameCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        GameCategory::factory(10)->create();
        //  $faker = Faker::create();

        // Create 10 dummy Category
        // for ($i = 1; $i <= 10; $i++) {
        //     GameCategory::create([
        //         'sort_order' => $i,
        //         'name' => $name = ucfirst($faker->word()),
        //         'slug' => Str::slug($name),



        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,

        //         'creater_id' => 1,
        //         'updater_id' => 1,
        //         'deleter_id' => null,
        //         'status' => GameCategoryStatus::ACTIVE->value,
               
        //     ]);
        // }
    }
}
