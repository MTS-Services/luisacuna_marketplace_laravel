<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Category;
use App\Models\GameCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $games = Game::all();

        foreach ($games as $game) {
            foreach ($categories as $category) {
                GameCategory::create(
                    [
                        'game_id' => $game->id,
                        'category_id' => $category->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
