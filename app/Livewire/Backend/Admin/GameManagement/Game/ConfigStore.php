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
        
        // Find the category with configs
        $this->currentCategory = $this->categoryService->findData($slug, 'slug');
        
        if ($this->currentCategory) {
            $this->gameCategory = GameCategory::with(['configs' => function($query) {
                $query->orderBy('sort_order', 'asc');
            }])
                ->where('game_id', $this->game->id)
                ->where('category_id', $this->currentCategory->id)
                ->first();

            if ($this->gameCategory && $this->gameCategory->configs->isNotEmpty()) {
                $this->loadExistingConfigs();
            } else {
                $this->selectedDeliveryMethods = ['game_delivery'];
                $this->fields = [];
            }
        }
        
        $this->isLoading = false;
    }

    protected function loadExistingConfigs(): void
    {
        $deliveryConfig = $this->gameCategory->configs
            ->where('sort_order', 0)
            ->whereNull('field_name')
            ->first();
        
        $this->selectedDeliveryMethods = $deliveryConfig 
            ? $deliveryConfig->delivery_methods 
            : ['game_delivery'];

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
                    'sort_order' => $index,
                ];
            })
            ->toArray();
    }

    public function saveConfiguration(): void
    {
        // Validate
        if (empty($this->selectedDeliveryMethods)) {
            $this->error('Please select at least one delivery method');
            return;
        }

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

            // Save delivery methods record
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

            // Handle field records
            $existingFieldIds = collect($this->fields)->pluck('id')->filter()->toArray();
            
            GameConfig::where('game_category_id', $this->gameCategory->id)
                ->where('sort_order', '>', 0)
                ->whereNotIn('id', $existingFieldIds)
                ->delete();

            foreach ($this->fields as $index => $field) {
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
                    'delivery_methods' => null,
                    'sort_order' => $index + 1,
                ];

                if ($field['id']) {
                    GameConfig::where('id', $field['id'])->update($fieldData);
                } else {
                    GameConfig::create($fieldData);
                }
            }

            DB::commit();

            $this->gameCategory->load(['configs' => function($query) {
                $query->orderBy('sort_order', 'asc');
            }]);

            $this->success('Configuration saved successfully!');
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