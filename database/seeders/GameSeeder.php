<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Enums\GameStatus;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Game::factory(10)->create();

        Game::insert([
            [
                'sort_order' => 1,
                'name' => 'Blade Ball Tokens',
                'slug' => 'blade-ball-tokens',
                'description' => 'Blade Ball Tokens',
                'logo' => 'assets/images/home_page/game-1.png',
                'status' => GameStatus::ACTIVE->value,

                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',

               'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 2,
                'name' => 'Path Of Exile 2 Currency',
                'slug' => 'path-of-exile-2-currency',
                'description' => 'Path Of Exile 2 Currency',
                
                'logo' => 'assets/images/home_page/game-2.png',

                
                'status' => GameStatus::ACTIVE->value,
                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',
                
               'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'sort_order' => 3,
                'name' => 'RuneScape 3 Gold',
                'slug' => 'rune-scape-3-gold',
                'description' => 'RuneScape 3 Gold',
                'logo' => 'assets/images/home_page/game-3.png',
                
                'status' => GameStatus::ACTIVE->value,
                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',
               
              'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 4,
                
                'name' => 'New World Coins',
                'slug' => 'new-world-coins',
                'description' => 'New World Coins',
               
                'logo' => 'assets/images/home_page/game-4.png',
               
                'status' => GameStatus::ACTIVE->value,
                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',
               
               'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 5,
               
                'name' => 'Lost Ark Gold',
                'slug' => 'lost-ark-gold',
                'description' => 'Lost Ark Gold',
               
                'logo' => 'assets/images/home_page/game-5.png',
                
                'status' => GameStatus::ACTIVE->value,
                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',
                
              'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sort_order' => 6,
               
                'name' => 'Old School RuneScape Gold',
                'slug' => 'old-school-runescape-gold',
                'description' => 'Old School RuneScape Gold',
                
                'logo' => 'assets/images/home_page/game-6.png',
                
                'status' => GameStatus::ACTIVE->value,
                'meta_title' => 'Blade Ball Tokens',
                'meta_description' => 'Blade Ball Tokens',
                'meta_keywords' => 'Blade Ball Tokens',
                
                'created_by' => Admin::inRandomorder()->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
