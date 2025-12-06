<?php

namespace App\Services;

use App\Models\GameConfig;
use App\Models\GameCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameConfigService
{
    /**
     * Load existing configurations for a game category
     */
    public function loadConfigurations(GameCategory $gameCategory): array
    {
        $configs = $gameCategory->configs()
            ->ordered()
            ->get();

        return [
            'delivery_methods' => $this->extractDeliveryMethods($configs),
            'fields' => $this->extractFields($configs),
        ];
    }

    /**
     * Extract delivery methods from configs
     */
    protected function extractDeliveryMethods(Collection $configs): array
    {
        $deliveryConfig = $configs
            ->where('sort_order', 0)
            ->whereNull('field_name')
            ->first();

        return $deliveryConfig?->delivery_methods ?? ['game_delivery'];
    }

    /**
     * Extract fields from configs
     */
    protected function extractFields(Collection $configs): array
    {
        return $configs
            ->where('sort_order', '>', 0)
            ->filter(fn($config) => !empty($config->field_name))
            ->values()
            ->map(fn($config, $index) => [
                'id' => $config->id,
                'field_name' => $config->field_name,
                'slug' => $config->slug,
                'input_type' => $config->input_type->value,
                'filter_type' => $config->filter_type->value,
                'dropdown_values' => is_array($config->dropdown_values)
                    ? implode(', ', $config->dropdown_values)
                    : '',
                'sort_order' => $index,
            ])
            ->toArray();
    }

    /**
     * Validate configuration data
     */
    public function validate(array $deliveryMethods, array $fields): ?string
    {
        if (empty($deliveryMethods)) {
            return 'Please select at least one delivery method';
        }

        foreach ($fields as $index => $field) {
            if (empty($field['field_name'])) {
                return "Field #" . ($index + 1) . " name is required";
            }
            if (empty($field['slug'])) {
                return "Field #" . ($index + 1) . " slug is required";
            }
        }

        return null;
    }

    /**
     * Save configuration for a game category
     */
    public function saveConfiguration(
        GameCategory $gameCategory,
        int $gameId,
        int $categoryId,
        array $deliveryMethods,
        array $fields
    ): void {
        DB::transaction(function () use ($gameCategory, $gameId, $categoryId, $deliveryMethods, $fields) {
            // Save delivery methods
            $this->saveDeliveryMethods(
                $gameCategory->id,
                $gameId,
                $categoryId,
                $deliveryMethods
            );

            // Save fields
            $this->saveFields(
                $gameCategory->id,
                $gameId,
                $categoryId,
                $fields
            );
        });
    }

    /**
     * Save delivery methods configuration
     */
    protected function saveDeliveryMethods(
        int $gameCategoryId,
        int $gameId,
        int $categoryId,
        array $deliveryMethods
    ): void {
        GameConfig::updateOrCreate(
            [
                'game_category_id' => $gameCategoryId,
                'sort_order' => 0,
            ],
            [
                'game_id' => $gameId,
                'category_id' => $categoryId,
                'field_name' => null,
                'slug' => null,
                'input_type' => null,
                'filter_type' => null,
                'dropdown_values' => null,
                'delivery_methods' => $deliveryMethods,
            ]
        );
    }

    /**
     * Save field configurations
     */
    protected function saveFields(
        int $gameCategoryId,
        int $gameId,
        int $categoryId,
        array $fields
    ): void {
        // Delete removed fields
        $this->deleteRemovedFields($gameCategoryId, $fields);

        // Save or update each field
        foreach ($fields as $index => $field) {
            $this->saveField($gameCategoryId, $gameId, $categoryId, $field, $index);
        }
    }

    /**
     * Delete fields that were removed
     */
    protected function deleteRemovedFields(int $gameCategoryId, array $fields): void
    {
        $existingFieldIds = collect($fields)
            ->pluck('id')
            ->filter()
            ->toArray();

        GameConfig::forGameCategory($gameCategoryId)
            ->where('sort_order', '>', 0)
            ->whereNotIn('id', $existingFieldIds)
            ->delete();
    }

    /**
     * Save a single field
     */
    protected function saveField(
        int $gameCategoryId,
        int $gameId,
        int $categoryId,
        array $field,
        int $index
    ): void {
        $fieldData = $this->prepareFieldData(
            $gameCategoryId,
            $gameId,
            $categoryId,
            $field,
            $index
        );

        if (!empty($field['id'])) {
            GameConfig::where('id', $field['id'])->update($fieldData);
        } else {
            GameConfig::create($fieldData);
        }
    }

    /**
     * Prepare field data for saving
     */
    protected function prepareFieldData(
        int $gameCategoryId,
        int $gameId,
        int $categoryId,
        array $field,
        int $index
    ): array {
        return [
            'game_id' => $gameId,
            'category_id' => $categoryId,
            'game_category_id' => $gameCategoryId,
            'field_name' => $field['field_name'],
            'slug' => $field['slug'],
            'input_type' => $field['input_type'],
            'filter_type' => $field['filter_type'],
            'dropdown_values' => $this->parseDropdownValues($field['dropdown_values'] ?? ''),
            'delivery_methods' => null,
            'sort_order' => $index + 1,
        ];
    }

    /**
     * Parse dropdown values from comma-separated string
     */
    protected function parseDropdownValues(string $dropdownValues): ?array
    {
        if (empty($dropdownValues)) {
            return null;
        }

        $values = array_map('trim', explode(',', $dropdownValues));
        $values = array_filter($values);

        return !empty($values) ? array_values($values) : null;
    }

    /**
     * Get game category with configs
     */
    public function getGameCategoryWithConfigs(int $gameId, int $categoryId): ?GameCategory
    {
        return GameCategory::with(['configs' => fn($query) => $query->ordered()])
            ->where('game_id', $gameId)
            ->where('category_id', $categoryId)
            ->first();
    }

    /**
     * Delete a specific field configuration
     */
    public function deleteField(int $fieldId): bool
    {
        try {
            return (bool) GameConfig::destroy($fieldId);
        } catch (\Exception $e) {
            Log::error('Error deleting game config field', [
                'field_id' => $fieldId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Duplicate configuration to another game category
     */
    public function duplicateConfiguration(
        GameCategory $sourceGameCategory,
        GameCategory $targetGameCategory
    ): void {
        $configs = $this->loadConfigurations($sourceGameCategory);

        $this->saveConfiguration(
            $targetGameCategory,
            $targetGameCategory->game_id,
            $targetGameCategory->category_id,
            $configs['delivery_methods'],
            array_map(fn($field) => array_merge($field, ['id' => null]), $configs['fields'])
        );
    }

    /**
     * Get fields by filter type
     */
    public function getFieldsByFilterType(GameCategory $gameCategory, string $filterType): Collection
    {
        return $gameCategory->configs()
            ->where('filter_type', $filterType)
            ->where('sort_order', '>', 0)
            ->whereNotNull('field_name')
            ->ordered()
            ->get();
    }

    /**
     * Check if delivery method is enabled
     */
    public function isDeliveryMethodEnabled(GameCategory $gameCategory, string $method): bool
    {
        $config = $gameCategory->configs()
            ->where('sort_order', 0)
            ->whereNull('field_name')
            ->first();

        return in_array($method, $config?->delivery_methods ?? []);
    }
}
