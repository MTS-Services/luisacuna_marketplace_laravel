<?php

namespace Database\Seeders;





use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


       Favorite::factory(5)->create();
    }
}
