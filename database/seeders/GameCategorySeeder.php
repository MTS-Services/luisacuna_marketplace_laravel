<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories
        $currencyId = Category::where('slug', 'currency')->value('id');
        $giftCardId = Category::where('slug', 'gift-card')->value('id');
        $boostingId = Category::where('slug', 'boosting')->value('id');
        $itemsId = Category::where('slug', 'items')->value('id');
        $accountsId = Category::where('slug', 'accounts')->value('id');
        $topUpId = Category::where('slug', 'top-up')->value('id');
        $coachingId = Category::where('slug', 'coaching')->value('id');

        // Get all games
        $games = Game::all();

        // Assign 12 games to each category
        $gameCategories = [];

        // Currency - First 12 games
        foreach ($games->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $currencyId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Gift Card - Next 12 games (or repeat from start if less than 24 games)
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $giftCardId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Boosting - Next 12 games
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $boostingId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Items - Next 12 games
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $itemsId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Accounts - Next 12 games
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $accountsId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Top Up - Next 12 games
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $topUpId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Coaching - Last 12 games
        foreach ($games->skip(0)->take(12) as $game) {
            $gameCategories[] = [
                'game_id' => $game->id,
                'category_id' => $coachingId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('game_categories')->insert($gameCategories);
    }
}