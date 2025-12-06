<?php

namespace App\Services;

use App\Models\GameConfig;
use App\Models\GameCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameConfigService
{
    public function __construct(
        protected GameConfig $model
    ) {}

    /**
     * Get all configs for a game category
     */
    public function getConfigsByGameCategory(int $gameCategoryId): Collection
    {
        return $this->model->newQuery()
            ->where('game_category_id', $gameCategoryId)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Get configs by game and category
     */
    public function getConfigsByGameAndCategory(int $gameId, int $categoryId): Collection
    {
        return $this->model->newQuery()
            ->where('game_id', $gameId)
            ->where('category_id', $categoryId)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Create or update configs for a game category
     */
    public function syncConfigs(GameCategory $gameCategory, array $configs, array $deliveryMethods): void
    {
        DB::transaction(function () use ($gameCategory, $configs, $deliveryMethods) {
            // Get existing config IDs
            $existingIds = collect($configs)->pluck('id')->filter()->toArray();

            // Delete configs that are no longer in the list
            $this->model->where('game_category_id', $gameCategory->id)
                ->whereNotIn('id', $existingIds)
                ->delete();

            // Create or update configs
            foreach ($configs as $index => $config) {
                $data = [
                    'game_id' => $gameCategory->game_id,
                    'category_id' => $gameCategory->category_id,
                    'game_category_id' => $gameCategory->id,
                    'field_name' => $config['field_name'],
                    'slug' => $config['slug'],
                    'input_type' => $config['input_type'],
                    'filter_type' => $config['filter_type'],
                    'dropdown_values' => !empty($config['dropdown_values']) ? $config['dropdown_values'] : null,
                    'delivery_methods' => $deliveryMethods,
                    'sort_order' => $index,
                ];

                if (!empty($config['id'])) {
                    // Update existing
                    $this->model->where('id', $config['id'])->update($data);
                } else {
                    // Create new
                    $this->model->create($data);
                }
            }
        });
    }
    // public function syncConfigs(GameCategory $gameCategory, array $configs, array $deliveryMethods): void
    // {
    //     DB::transaction(function () use ($gameCategory, $configs, $deliveryMethods) {
    //         // Get existing config IDs
    //         $existingIds = collect($configs)->pluck('id')->filter()->toArray();

    //         // Delete configs that are no longer in the list
    //         $this->model->where('game_category_id', $gameCategory->id)
    //             ->whereNotIn('id', $existingIds)
    //             ->delete();

    //         // Create or update configs
    //         foreach ($configs as $index => $config) {
    //             $data = [
    //                 'game_id' => $gameCategory->game_id,
    //                 'category_id' => $gameCategory->category_id,
    //                 'game_category_id' => $gameCategory->id,
    //                 'field_name' => $config['field_name'],
    //                 'slug' => $config['slug'],
    //                 'input_type' => $config['input_type'],
    //                 'filter_type' => $config['filter_type'],
    //                 'dropdown_values' => !empty($config['dropdown_values']) ? $config['dropdown_values'] : null,
    //                 'delivery_methods' => $deliveryMethods,
    //                 'sort_order' => $index,
    //             ];

    //             if (!empty($config['id'])) {
    //                 // Update existing
    //                 $this->model->where('id', $config['id'])->update($data);
    //             } else {
    //                 // Create new
    //                 $this->model->create($data);
    //             }
    //         }
    //     });
    // }

    /**
     * Delete a specific config
     */
    public function deleteConfig(int $id): bool
    {
        $config = $this->model->find($id);
        return $config ? $config->delete() : false;
    }

    /**
     * Reorder configs
     */
    public function reorderConfigs(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                $this->model->where('id', $id)->update(['sort_order' => $index]);
            }
        });
    }

    /**
     * Get delivery methods for a game category
     */
    public function getDeliveryMethods(int $gameCategoryId): array
    {
        $config = $this->model->where('game_category_id', $gameCategoryId)->first();
        return $config ? $config->delivery_methods : [];
    }

    /**
     * Check if a slug is unique within a game category
     */
    public function isSlugUnique(string $slug, int $gameCategoryId, ?int $excludeId = null): bool
    {
        $query = $this->model->where('game_category_id', $gameCategoryId)
            ->where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->doesntExist();
    }
}
