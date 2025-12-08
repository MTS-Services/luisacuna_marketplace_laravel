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
    protected GameConfigService $gameConfigService;

    public function __construct(GameConfigService $gameConfigService)
    {
        $this->gameConfigService = $gameConfigService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎮 Starting Game Config Seeder...');

        $games = Game::with('categories')->get();

        if ($games->isEmpty()) {
            $this->command->warn('⚠️  No games found. Please run GameSeeder first.');
            return;
        }

        $totalConfigs = 0;

        foreach ($games as $game) {
            $this->command->info("📦 Processing game: {$game->name}");

            if ($game->categories->isEmpty()) {
                $this->command->warn("   ⚠️  No categories assigned to {$game->name}");
                continue;
            }

            foreach ($game->categories as $category) {
                $gameCategory = GameCategory::where('game_id', $game->id)
                    ->where('category_id', $category->id)
                    ->first();

                if (!$gameCategory) {
                    $this->command->warn("   ⚠️  Game category not found for {$category->name}");
                    continue;
                }

                try {
                    // Get sample configs for this category
                    $configs = $this->getSampleConfigsForCategory($game, $category);

                    // Save using service
                    $this->gameConfigService->saveConfiguration(
                        $gameCategory,
                        $game->id,
                        $category->id,
                        $configs['delivery_methods'],
                        $configs['fields']
                    );

                    $fieldCount = count($configs['fields']);
                    $totalConfigs += $fieldCount;

                    $this->command->info("   ✅ Created {$fieldCount} fields for category: {$category->name}");
                } catch (\Exception $e) {
                    $this->command->error("   ❌ Error creating config for {$category->name}: {$e->getMessage()}");
                    Log::error('GameConfigSeeder error', [
                        'game' => $game->name,
                        'category' => $category->name,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $this->command->newLine();
        }

        $this->command->info("🎉 Game Config Seeder completed! Total configs created: {$totalConfigs}");
    }

    /**
     * Get sample configurations for a specific category
     */
    protected function getSampleConfigsForCategory(Game $game, $category): array
    {
        // Get category-specific configs
        $categoryConfigs = $this->getCategorySpecificConfigs($category->slug);

        // If no specific config, use default
        if (empty($categoryConfigs)) {
            $categoryConfigs = $this->getDefaultConfigs();
        }

        return [
            'delivery_methods' => $this->getDeliveryMethodsForCategory(),
            'fields' => $categoryConfigs,
        ];
    }

    /**
     * Get delivery methods based on category
     */
    protected function getDeliveryMethodsForCategory(): array
    {
        return ['instant', 'manual'];
    }

    /**
     * Get category-specific configurations
     */
    protected function getCategorySpecificConfigs(string $categorySlug): array
    {
        $slug = strtolower($categorySlug);

        return match ($slug) {
            'accounts' => $this->getAccountsConfigs(),
            'gold', 'currency' => $this->getGoldConfigs(),
            'items' => $this->getItemsConfigs(),
            'boosting' => $this->getBoostingConfigs(),
            'power-leveling' => $this->getPowerLevelingConfigs(),
            'coaching' => $this->getCoachingConfigs(),
            'services' => $this->getServicesConfigs(),
            default => $this->getDefaultConfigs(),
        };
    }

    /**
     * Accounts category configs
     */
    protected function getAccountsConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Account Level',
                'slug' => 'account-level',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Server Region',
                'slug' => 'server-region',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'North America, Europe, Asia, South America, Oceania',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Account Rank',
                'slug' => 'account-rank',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Bronze, Silver, Gold, Platinum, Diamond, Master, Grandmaster',
                'sort_order' => 2,
            ],
            [
                'id' => null,
                'field_name' => 'Champions/Heroes Owned',
                'slug' => 'champions-owned',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 3,
            ],
        ];
    }

    /**
     * Gold/Currency category configs
     */
    protected function getGoldConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Amount',
                'slug' => 'amount',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Server',
                'slug' => 'server',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'NA, EU, Asia, OCE, SA',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Delivery Speed',
                'slug' => 'delivery-speed',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Instant, 1-2 Hours, 3-6 Hours, 12-24 Hours',
                'sort_order' => 2,
            ],
        ];
    }

    /**
     * Items category configs
     */
    protected function getItemsConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Item Type',
                'slug' => 'item-type',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Weapon, Armor, Accessory, Consumable, Material, Mount, Pet',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Item Rarity',
                'slug' => 'item-rarity',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Common, Uncommon, Rare, Epic, Legendary, Mythic',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Quantity',
                'slug' => 'quantity',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 2,
            ],
            [
                'id' => null,
                'field_name' => 'Server',
                'slug' => 'server',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'NA, EU, Asia, OCE',
                'sort_order' => 3,
            ],
        ];
    }

    /**
     * Boosting category configs
     */
    protected function getBoostingConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Current Rank',
                'slug' => 'current-rank',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Bronze, Silver, Gold, Platinum, Diamond',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Desired Rank',
                'slug' => 'desired-rank',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Silver, Gold, Platinum, Diamond, Master, Grandmaster',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Boost Type',
                'slug' => 'boost-type',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Solo Queue, Duo Queue, Placement Matches, Win Boosting',
                'sort_order' => 2,
            ],
            [
                'id' => null,
                'field_name' => 'Server Region',
                'slug' => 'server-region',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'NA, EU West, EU East, Asia, OCE',
                'sort_order' => 3,
            ],
        ];
    }

    /**
     * Power Leveling category configs
     */
    protected function getPowerLevelingConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Current Level',
                'slug' => 'current-level',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Desired Level',
                'slug' => 'desired-level',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Leveling Method',
                'slug' => 'leveling-method',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Questing, Dungeon Grinding, PvP, Mixed',
                'sort_order' => 2,
            ],
        ];
    }

    /**
     * Coaching category configs
     */
    protected function getCoachingConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Session Duration',
                'slug' => 'session-duration',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => '1 Hour, 2 Hours, 3 Hours, 5 Hours, 10 Hours',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Focus Area',
                'slug' => 'focus-area',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Mechanics, Strategy, Character Specific, Team Play, Meta Analysis',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Skill Level',
                'slug' => 'skill-level',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Beginner, Intermediate, Advanced, Expert',
                'sort_order' => 2,
            ],
        ];
    }

    /**
     * Services category configs
     */
    protected function getServicesConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Service Type',
                'slug' => 'service-type',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Achievement, Quest Completion, Raid Carry, Dungeon Run, Event Service',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Difficulty',
                'slug' => 'difficulty',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Normal, Hard, Heroic, Mythic, Nightmare',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Completion Time',
                'slug' => 'completion-time',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => '1-3 Days, 3-7 Days, 1-2 Weeks, 2-4 Weeks',
                'sort_order' => 2,
            ],
        ];
    }

    /**
     * Default configs for categories without specific configurations
     */
    protected function getDefaultConfigs(): array
    {
        return [
            [
                'id' => null,
                'field_name' => 'Server',
                'slug' => 'server',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'North America, Europe, Asia, Oceania',
                'sort_order' => 0,
            ],
            [
                'id' => null,
                'field_name' => 'Quantity',
                'slug' => 'quantity',
                'input_type' => GameConfigInputType::NUMBER->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_RANGE->value,
                'dropdown_values' => '',
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'field_name' => 'Delivery Time',
                'slug' => 'delivery-time',
                'input_type' => GameConfigInputType::SELECT_DROPDOWN->value,
                'filter_type' => GameConfigFilterType::FILTER_BY_SELECT->value,
                'dropdown_values' => 'Instant, 1-2 Hours, 3-6 Hours, 12-24 Hours, 1-3 Days',
                'sort_order' => 2,
            ],
        ];
    }
}
