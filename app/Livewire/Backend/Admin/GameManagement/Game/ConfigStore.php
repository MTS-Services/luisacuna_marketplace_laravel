<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Models\Game;
use App\Models\Category;
use App\Models\GameCategory;
use App\Services\CategoryService;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfigStore extends Component
{
    public Game $game;
    public bool $showConfigModal = false;
    public bool $isLoading = false;
    public ?string $configuringCategorySlug = null;
    public ?Category $currentCategory = null;
    public ?GameCategory $gameCategory = null;

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
            $this->gameCategory = GameCategory::with('configs')
                ->where('game_id', $this->game->id)
                ->where('category_id', $this->currentCategory->id)
                ->first();
        }

        $this->isLoading = false;
    }

    public function closeConfigModal(): void
    {
        $this->showConfigModal = false;
        $this->isLoading = false;
        $this->configuringCategorySlug = null;
        $this->currentCategory = null;
        $this->gameCategory = null;
    }

    public function render()
    {
        return view('livewire.backend.admin.game-management.game.config-store');
    }
}
