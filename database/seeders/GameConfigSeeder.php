<?php

namespace Database\Seeders;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use App\Models\Game;
use App\Models\GameCategory;
use App\Services\GameConfigService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class GameConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎮 GameConfigSeeder started');

        /** @var GameConfigService $service */
        $service = app(GameConfigService::class);

        $games = Game::with('categories')->get();

        if ($games->isEmpty()) {
            $this->command->warn('⚠️ No games found. Run GameSeeder first.');
            return;
        }

        $totalFields = 0;

        foreach ($games as $game) {
            $this->command->info("📦 Game: {$game->name}");

            foreach ($game->categories as $category) {

                $gameCategory = GameCategory::where([
                    'game_id' => $game->id,
                    'category_id' => $category->id,
                ])->first();

                if (!$gameCategory) {
                    $this->command->warn("   ⚠️ Missing GameCategory ({$category->name})");
                    continue;
                }

                try {
                    $fields = $this->getConfigsForCategory($category->slug);

                    $service->saveConfiguration(
                        $gameCategory,
                        $game->id,
                        $category->id,
                        $this->deliveryMethods(),
                        $fields
                    );

                    $count = count($fields);
                    $totalFields += $count;

                    $this->command->info("   ✅ {$category->name}: {$count} fields saved");
                } catch (\Throwable $e) {
                    Log::error('GameConfigSeeder failed', [
                        'game_id' => $game->id,
                        'category_id' => $category->id,
                        'error' => $e->getMessage(),
                    ]);

                    $this->command->error("   ❌ {$category->name}: {$e->getMessage()}");
                }
            }

            $this->command->newLine();
        }

        $this->command->info("🎉 GameConfigSeeder finished. Total fields created: {$totalFields}");
    }

    /* ============================================================
        DELIVERY METHODS
    ============================================================ */

    protected function deliveryMethods(): array
    {
        return ['instant', 'manual'];
    }

    /* ============================================================
        CATEGORY CONFIG ROUTER
    ============================================================ */

    protected function getConfigsForCategory(string $slug): array
    {
        return match (strtolower($slug)) {
            'accounts' => $this->accounts(),
            'gold', 'currency' => $this->currency(),
            'items' => $this->items(),
            'boosting' => $this->boosting(),
            'power-leveling' => $this->powerLeveling(),
            'coaching' => $this->coaching(),
            'services' => $this->services(),
            default => $this->default(),
        };
    }

    /* ============================================================
        CONFIG DEFINITIONS
    ============================================================ */

    protected function accounts(): array
    {
        return [
            $this->select('Server Region', 'server-region', 'NA, EU, Asia, SA, OCE', 0),
            $this->select('Account Rank', 'account-rank', 'Bronze, Silver, Gold, Platinum, Diamond, Master', 1),
            $this->number('Account Level', 'account-level', 2),
            $this->number('Heroes Owned', 'heroes-owned', 3),
        ];
    }

    protected function currency(): array
    {
        return [
            $this->number('Amount', 'amount', 0),
            $this->select('Server', 'server', 'NA, EU, Asia, OCE', 1),
            $this->select('Delivery Speed', 'delivery-speed', 'Instant, 1-2 Hours, 6-12 Hours', 2),
        ];
    }

    protected function items(): array
    {
        return [
            $this->select('Item Type', 'item-type', 'Weapon, Armor, Consumable, Material', 0),
            $this->select('Rarity', 'rarity', 'Common, Rare, Epic, Legendary', 1),
            $this->number('Quantity', 'quantity', 2),
        ];
    }

    protected function boosting(): array
    {
        return [
            $this->select('Current Rank', 'current-rank', 'Bronze, Silver, Gold, Platinum, Diamond', 0),
            $this->select('Target Rank', 'target-rank', 'Gold, Platinum, Diamond, Master', 1),
            $this->select('Queue Type', 'queue-type', 'Solo, Duo', 2),
        ];
    }

    protected function powerLeveling(): array
    {
        return [
            $this->number('Current Level', 'current-level', 0),
            $this->number('Target Level', 'target-level', 1),
        ];
    }

    protected function coaching(): array
    {
        return [
            $this->select('Session Length', 'session-length', '1 Hour, 2 Hours, 5 Hours', 0),
            $this->select('Skill Level', 'skill-level', 'Beginner, Intermediate, Advanced', 1),
        ];
    }

    protected function services(): array
    {
        return [
            $this->select('Service Type', 'service-type', 'Quest, Dungeon, Raid, Achievement', 0),
            $this->select('Difficulty', 'difficulty', 'Normal, Hard, Mythic', 1),
        ];
    }

    protected function default(): array
    {
        return [
            $this->select('Server', 'server', 'NA, EU, Asia, OCE', 0),
            $this->number('Quantity', 'quantity', 1),
        ];
    }

    /* ============================================================
        FIELD BUILDERS (REUSABLE)
    ============================================================ */

    protected function select(
        string $name,
        string $slug,
        string $values,
        int $order
    ): array {
        return [
            'id' => null,
            'field_name' => $name,
            'slug' => $slug,
            'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
            'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
            'dropdown_values' => $values,
            'sort_order' => $order,
        ];
    }

    protected function number(
        string $name,
        string $slug,
        int $order
    ): array {
        return [
            'id' => null,
            'field_name' => $name,
            'slug' => $slug,
            'input_type' => GameConfigInputType::NUMBER->value,
            'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
            'dropdown_values' => '',
            'sort_order' => $order,
        ];
    }
}
