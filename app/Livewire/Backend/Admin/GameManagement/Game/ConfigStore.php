<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use App\Models\Game;
use App\Models\Category;
use App\Models\GameCategory;
use App\Services\CategoryService;
use App\Services\GameConfigService;
use App\Traits\Livewire\WithNotification;
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
    protected GameConfigService $gameConfigService;

    public function boot(
        CategoryService $categoryService,
        GameConfigService $gameConfigService
    ): void {
        $this->categoryService = $categoryService;
        $this->gameConfigService = $gameConfigService;
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

        if (!$this->currentCategory) {
            $this->error('Category not found');
            $this->isLoading = false;
            return;
        }

        // Get game category with configs
        $this->gameCategory = $this->gameConfigService->getGameCategoryWithConfigs(
            $this->game->id,
            $this->currentCategory->id
        );

        // Load existing configurations or set defaults
        if ($this->gameCategory && $this->gameCategory->configs->isNotEmpty()) {
            $this->loadExistingConfigs();
        } else {
            $this->setDefaultConfig();
        }

        $this->isLoading = false;
    }

    /**
     * Load existing configurations
     */
    protected function loadExistingConfigs(): void
    {
        $configs = $this->gameConfigService->loadConfigurations($this->gameCategory);

        $this->selectedDeliveryMethods = $configs['delivery_methods'];
        $this->fields = $configs['fields'];
    }

    /**
     * Set default configuration
     */
    protected function setDefaultConfig(): void
    {
        $this->selectedDeliveryMethods = ['game_delivery'];
        $this->fields = [];
    }

    /**
     * Save configuration
     */
    public function saveConfiguration(): void
    {
        // Validate using service
        $validationError = $this->gameConfigService->validate(
            $this->selectedDeliveryMethods,
            $this->fields
        );

        if ($validationError) {
            $this->error($validationError);
            return;
        }

        if (!$this->gameCategory) {
            $this->error('Game category not found');
            return;
        }

        try {
            // Save using service
            $this->gameConfigService->saveConfiguration(
                $this->gameCategory,
                $this->game->id,
                $this->currentCategory->id,
                $this->selectedDeliveryMethods,
                $this->fields
            );

            // Reload configs
            $this->gameCategory->load(['configs' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }]);

            $this->success('Configuration saved successfully!');
            $this->dispatch('refreshGameCategories');
        } catch (\Exception $e) {
            $this->error('Error saving configuration. Please try again.');
        }
    }

    /**
     * Close modal and reset state
     */
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
