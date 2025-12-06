<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use App\Models\Game;
use App\Models\Category;
use App\Models\GameCategory;
use App\Models\GameConfig;
use App\Services\CategoryService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfigStore extends Component
{
    use WithNotification;

    public Game $game;
    public bool $showConfigModal = false;
    public bool $isLoading = false;
    public ?string $configuringCategorySlug = null;
    public ?Category $currentCategory = null;
    public ?GameCategory $gameCategory = null;

    // Delivery Methods
    public array $selectedDeliveryMethods = [];
    
    // Dynamic Fields
    public array $fields = [];

    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService): void
    {
        $this->categoryService = $categoryService;
    }

    public function mount(Game $game): void
    {
        $this->game = $game;
    }

    #[On('openConfigModal')]
    public function openConfigModal(string $slug): void
    {
        $this->isLoading = true;
        $this->configuringCategorySlug = $slug;
        
        // Find the category
        $this->currentCategory = $this->categoryService->findData($slug, 'slug');
        
        if ($this->currentCategory) {
            // Get the game category relationship with configs eager loaded
            $this->gameCategory = GameCategory::with(['configs' => function($query) {
                $query->orderBy('sort_order', 'asc');
            }])
                ->where('game_id', $this->game->id)
                ->where('category_id', $this->currentCategory->id)
                ->first();

            // Load existing configurations
            if ($this->gameCategory && $this->gameCategory->configs->isNotEmpty()) {
                $this->loadExistingConfigs();
            } else {
                // Initialize with default delivery methods if no configs exist
                $this->selectedDeliveryMethods = ['game_delivery'];
                $this->fields = [];
            }
        }
        
        $this->isLoading = false;
    }

    protected function loadExistingConfigs(): void
    {
        // Find the delivery methods record (where field_name is NULL and sort_order = 0)
        $deliveryConfig = $this->gameCategory->configs
            ->where('sort_order', 0)
            ->whereNull('field_name')
            ->first();
        
        $this->selectedDeliveryMethods = $deliveryConfig 
            ? $deliveryConfig->delivery_methods 
            : ['game_delivery'];

        // Load all field configs (where field_name is not null and sort_order > 0)
        $this->fields = $this->gameCategory->configs
            ->where('sort_order', '>', 0)
            ->filter(fn($config) => !empty($config->field_name))
            ->values()
            ->map(function($config, $index) {
                return [
                    'id' => $config->id,
                    'field_name' => $config->field_name,
                    'slug' => $config->slug,
                    'input_type' => $config->input_type,
                    'filter_type' => $config->filter_type,
                    'dropdown_values' => is_array($config->dropdown_values) 
                        ? implode(', ', $config->dropdown_values) 
                        : '',
                    'sort_order' => $index, // Re-index from 0
                ];
            })
            ->toArray();
    }

    public function addField(): void
    {
        $this->fields[] = [
            'id' => null,
            'field_name' => '',
            'slug' => '',
            'input_type' => GameConfigInputType::TEXT->value,
            'filter_type' => GameConfigFilterType::NO_FILTER->value,
            'dropdown_values' => '',
            'sort_order' => count($this->fields),
        ];
    }

    public function removeField(int $index): void
    {
        if (isset($this->fields[$index])) {
            $fieldId = $this->fields[$index]['id'];
            
            // Remove from array
            unset($this->fields[$index]);
            $this->fields = array_values($this->fields);
            
            // Update sort orders
            foreach ($this->fields as $idx => $field) {
                $this->fields[$idx]['sort_order'] = $idx;
            }

            // If field exists in database, delete it
            if ($fieldId) {
                try {
                    GameConfig::find($fieldId)?->delete();
                } catch (\Exception $e) {
                    Log::error('Error deleting game config field', [
                        'field_id' => $fieldId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    public function moveFieldUp(int $index): void
    {
        if ($index > 0 && isset($this->fields[$index])) {
            $temp = $this->fields[$index];
            $this->fields[$index] = $this->fields[$index - 1];
            $this->fields[$index - 1] = $temp;
            
            // Update sort orders
            $this->fields[$index]['sort_order'] = $index;
            $this->fields[$index - 1]['sort_order'] = $index - 1;
        }
    }

    public function moveFieldDown(int $index): void
    {
        if ($index < count($this->fields) - 1 && isset($this->fields[$index])) {
            $temp = $this->fields[$index];
            $this->fields[$index] = $this->fields[$index + 1];
            $this->fields[$index + 1] = $temp;
            
            // Update sort orders
            $this->fields[$index]['sort_order'] = $index;
            $this->fields[$index + 1]['sort_order'] = $index + 1;
        }
    }

    public function saveConfiguration(): void
    {
        // Basic validation
        if (empty($this->selectedDeliveryMethods)) {
            $this->error('Please select at least one delivery method');
            return;
        }

        // Validate fields
        foreach ($this->fields as $index => $field) {
            if (empty($field['field_name'])) {
                $this->error("Field #" . ($index + 1) . " name is required");
                return;
            }
            if (empty($field['slug'])) {
                $this->error("Field #" . ($index + 1) . " slug is required");
                return;
            }
        }

        if (!$this->gameCategory) {
            $this->error('Game category not found');
            return;
        }

        try {
            DB::beginTransaction();

            // 1. SAVE/UPDATE DELIVERY METHODS RECORD ONLY (sort_order = 0)
            GameConfig::updateOrCreate(
                [
                    'game_category_id' => $this->gameCategory->id,
                    'sort_order' => 0,
                ],
                [
                    'game_id' => $this->game->id,
                    'category_id' => $this->currentCategory->id,
                    'field_name' => null,
                    'slug' => null,
                    'input_type' => null,
                    'filter_type' => null,
                    'dropdown_values' => null,
                    'delivery_methods' => $this->selectedDeliveryMethods,
                ]
            );

            // 2. HANDLE FIELD RECORDS (sort_order > 0)
            // Get existing field IDs
            $existingFieldIds = collect($this->fields)->pluck('id')->filter()->toArray();
            
            // Delete field records that were removed (keep delivery methods record)
            GameConfig::where('game_category_id', $this->gameCategory->id)
                ->where('sort_order', '>', 0)
                ->whereNotIn('id', $existingFieldIds)
                ->delete();

            // Save or update each field as a separate record
            foreach ($this->fields as $index => $field) {
                // Parse dropdown values
                $dropdownValues = null;
                if (!empty($field['dropdown_values'])) {
                    $values = array_map('trim', explode(',', $field['dropdown_values']));
                    $values = array_filter($values);
                    $dropdownValues = !empty($values) ? array_values($values) : null;
                }

                $fieldData = [
                    'game_id' => $this->game->id,
                    'category_id' => $this->currentCategory->id,
                    'game_category_id' => $this->gameCategory->id,
                    'field_name' => $field['field_name'],
                    'slug' => $field['slug'],
                    'input_type' => $field['input_type'],
                    'filter_type' => $field['filter_type'],
                    'dropdown_values' => $dropdownValues,
                    'delivery_methods' => null, // DO NOT store in field records
                    'sort_order' => $index + 1, // Start from 1 (0 is for delivery methods)
                ];

                if ($field['id']) {
                    // Update existing field
                    GameConfig::where('id', $field['id'])->update($fieldData);
                } else {
                    // Create new field
                    GameConfig::create($fieldData);
                }
            }

            DB::commit();

            // Reload configs
            $this->gameCategory->load(['configs' => function($query) {
                $query->orderBy('sort_order', 'asc');
            }]);

            $this->success('Configuration saved successfully!');
            
            // Dispatch event to refresh parent component
            $this->dispatch('refreshGameCategories');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error saving game configuration', [
                'game_id' => $this->game->id,
                'category_id' => $this->currentCategory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Error saving configuration. Please try again.');
        }
    }

    public function closeConfigModal(): void
    {
        $this->showConfigModal = false;
        $this->isLoading = false;
        $this->configuringCategorySlug = null;
        $this->currentCategory = null;
        $this->gameCategory = null;
        $this->selectedDeliveryMethods = [];
        $this->fields = [];
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.backend.admin.game-management.game.config-store', [
            'deliveryMethods' => delivery_methods(),
            'inputTypes' => GameConfigInputType::options(),
            'filterTypes' => GameConfigFilterType::options(),
        ]);
    }
}