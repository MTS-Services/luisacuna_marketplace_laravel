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

    // Field being edited
    public int $editingFieldIndex = -1;

    protected CategoryService $categoryService;

    protected $rules = [
        'selectedDeliveryMethods' => 'required|array|min:1',
        'fields.*.field_name' => 'required|string|max:255',
        'fields.*.slug' => 'required|string|max:255',
        'fields.*.input_type' => 'required|string',
        'fields.*.filter_type' => 'required|string',
        'fields.*.dropdown_values' => 'nullable|array',
        'fields.*.sort_order' => 'required|integer|min:0',
    ];

    protected $messages = [
        'selectedDeliveryMethods.required' => 'Please select at least one delivery method',
        'selectedDeliveryMethods.min' => 'Please select at least one delivery method',
        'fields.*.field_name.required' => 'Field name is required',
        'fields.*.slug.required' => 'Field slug is required',
    ];

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
            $this->gameCategory = GameCategory::with(['configs' => function ($query) {
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
        // Get delivery methods from first config (they should all be the same)
        $firstConfig = $this->gameCategory->configs->first();
        $this->selectedDeliveryMethods = $firstConfig ? $firstConfig->delivery_methods : ['game_delivery'];

        // Load all fields
        $this->fields = $this->gameCategory->configs->map(function ($config) {
            return [
                'id' => $config->id,
                'field_name' => $config->field_name,
                'slug' => $config->slug,
                'input_type' => $config->input_type,
                'filter_type' => $config->filter_type,
                'dropdown_values' => $config->dropdown_values ?? [],
                'sort_order' => $config->sort_order,
            ];
        })->toArray();
    }

    public function addField(): void
    {
        $this->fields[] = [
            'id' => null, // New field
            'field_name' => '',
            'slug' => '',
            'input_type' => GameConfigInputType::TEXT->value,
            'filter_type' => GameConfigFilterType::NO_FILTER->value,
            'dropdown_values' => [],
            'sort_order' => count($this->fields),
        ];
    }

    public function removeField(int $index): void
    {
        if (isset($this->fields[$index])) {
            // If field has an ID, it exists in database and should be deleted
            if ($this->fields[$index]['id']) {
                try {
                    GameConfig::find($this->fields[$index]['id'])?->delete();
                    $this->success('Field deleted successfully');
                } catch (\Exception $e) {
                    Log::error('Error deleting game config field', [
                        'field_id' => $this->fields[$index]['id'],
                        'error' => $e->getMessage(),
                    ]);
                    $this->error('Error deleting field');
                    return;
                }
            }

            unset($this->fields[$index]);
            $this->fields = array_values($this->fields); // Re-index array

            // Update sort orders
            foreach ($this->fields as $idx => $field) {
                $this->fields[$idx]['sort_order'] = $idx;
            }
        }
    }

    public function updateFieldName(int $index, string $value): void
    {
        if (isset($this->fields[$index])) {
            $this->fields[$index]['field_name'] = $value;
            // Auto-generate slug
            $this->fields[$index]['slug'] = Str::slug($value);
        }
    }

    public function updateFieldSlug(int $index, string $value): void
    {
        if (isset($this->fields[$index])) {
            $this->fields[$index]['slug'] = Str::slug($value);
        }
    }

    public function updateFieldInputType(int $index, string $value): void
    {
        if (isset($this->fields[$index])) {
            $this->fields[$index]['input_type'] = $value;

            // Reset dropdown values if changing away from select
            if ($value !== GameConfigInputType::SELECT_DROPDOWN->value) {
                $this->fields[$index]['dropdown_values'] = [];
            }
        }
    }

    public function updateFieldFilterType(int $index, string $value): void
    {
        if (isset($this->fields[$index])) {
            $this->fields[$index]['filter_type'] = $value;
        }
    }

    public function updateDropdownValues(int $index, string $value): void
    {
        if (isset($this->fields[$index])) {
            // Split by comma and trim whitespace
            $values = array_map('trim', explode(',', $value));
            $values = array_filter($values); // Remove empty values
            $this->fields[$index]['dropdown_values'] = array_values($values);
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
        $this->validate();

        if (!$this->gameCategory) {
            $this->error('Game category not found');
            return;
        }

        try {
            DB::beginTransaction();

            // Track existing field IDs
            $existingIds = collect($this->fields)->pluck('id')->filter()->toArray();

            // Delete fields that were removed
            GameConfig::where('game_category_id', $this->gameCategory->id)
                ->whereNotIn('id', $existingIds)
                ->delete();

            // Save or update fields
            foreach ($this->fields as $index => $field) {
                $data = [
                    'game_id' => $this->game->id,
                    'category_id' => $this->currentCategory->id,
                    'game_category_id' => $this->gameCategory->id,
                    'field_name' => $field['field_name'],
                    'slug' => $field['slug'],
                    'input_type' => $field['input_type'],
                    'filter_type' => $field['filter_type'],
                    'dropdown_values' => !empty($field['dropdown_values']) ? $field['dropdown_values'] : null,
                    'delivery_methods' => $this->selectedDeliveryMethods,
                    'sort_order' => $index,
                ];

                if ($field['id']) {
                    // Update existing
                    GameConfig::where('id', $field['id'])->update($data);
                } else {
                    // Create new
                    GameConfig::create($data);
                }
            }

            DB::commit();

            // Reload configs
            $this->gameCategory->load(['configs' => function ($query) {
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
