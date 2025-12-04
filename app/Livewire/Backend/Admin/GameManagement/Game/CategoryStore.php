<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\CategoryStatus;
use App\Models\Game;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CategoryStore extends Component
{
    use WithNotification;

    public Game $game;
    public ?string $selectedCategory = null;
    public bool $showConfigModal = false;
    public ?string $configuringCategorySlug = null;

    protected CategoryService $categoryService;
    protected GameService $gameService;

    public function boot(CategoryService $categoryService, GameService $gameService): void
    {
        $this->categoryService = $categoryService;
        $this->gameService = $gameService;
    }

    public function mount(Game $game): void
    {
        // Eager load categories to avoid N+1
        $this->game = $game->load('categories:id,name,slug');
    }

    /**
     * Computed property for all active categories
     * Cached automatically by Livewire
     */
    #[Computed]
    public function categories(): Collection
    {
        return $this->categoryService->getDatas(
            sortField: 'name',
            order: 'asc',
            status: CategoryStatus::ACTIVE->value,
            selects: ['id', 'name', 'slug']
        );
    }

    /**
     * Computed property for game categories
     * Cached automatically by Livewire
     */
    #[Computed]
    public function gameCategories(): Collection
    {
        return $this->game->categories;
    }

    /**
     * Computed property for remaining categories
     * Cached automatically by Livewire
     */
    #[Computed]
    public function remainingCategories(): Collection
    {
        $assignedIds = $this->gameCategories->pluck('id')->toArray();
        return $this->categories->whereNotIn('id', $assignedIds)->values();
    }


    #[On('saveGameCategory')]
    public function saveGameCategory(): void
    {
        $category = $this->categoryService->findData($this->selectedCategory, 'slug');

        if (!$category) {
            $this->error('Category not found');
            return;
        }

        // Check if category is already assigned, if not assign it first
        if (!$this->gameCategories->contains('id', $category->id)) {
            try {
                $this->gameService->saveGameCategory($this->game, $category);

                // Refresh the relationship efficiently
                $this->game->load('categories:id,name,slug');

                // Clear computed property cache
                unset($this->gameCategories, $this->remainingCategories);

                $this->success('Category assigned successfully!');
            } catch (\Exception $e) {
                Log::error('Error assigning category before configuration', [
                    'game_id' => $this->game->id,
                    'category_slug' => $this->selectedCategory,
                    'error' => $e->getMessage(),
                ]);

                $this->error('Error assigning category. Please try again.');
                return;
            }
        }
    }

    /**
     * Close configuration modal and reset
     */
    public function closeConfigModal(): void
    {
        $this->showConfigModal = false;
        $this->configuringCategorySlug = null;
        $this->reset(['selectedCategory']);
    }

    /**
     * Save category (for dropdown assignment)
     */
    public function saveCategory(): bool
    {
        $this->validate([
            'selectedCategory' => 'required|string|exists:categories,slug'
        ]);

        try {
            $category = $this->categoryService->findData($this->selectedCategory, 'slug');

            if (!$category) {
                $this->error('Category not found');
                return false;
            }

            // Check if already assigned
            if ($this->gameCategories->contains('id', $category->id)) {
                $this->warning('Category is already assigned to this game');
                return false;
            }

            $this->gameService->saveGameCategory($this->game, $category);

            // Refresh the relationship efficiently
            $this->game->load('categories:id,name,slug');

            // Clear computed property cache
            unset($this->gameCategories, $this->remainingCategories);

            $this->reset('selectedCategory');
            $this->success('Category saved successfully!');

            return true;
        } catch (\Exception $e) {
            Log::error('Error saving game category', [
                'game_id' => $this->game->id,
                'category_slug' => $this->selectedCategory,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Error saving category. Please try again.');
            return false;
        }
    }

    /**
     * Remove category
     */
    public function removeCategory(string $slug): bool
    {
        try {
            $category = $this->categoryService->findData($slug, 'slug');

            if (!$category) {
                $this->error('Category not found');
                return false;
            }

            // Check if category is assigned
            if (!$this->gameCategories->contains('id', $category->id)) {
                $this->warning('Category is not assigned to this game');
                return false;
            }

            $this->gameService->deleteGameCategory($this->game, $category);

            // Refresh the relationship efficiently
            $this->game->load('categories:id,name,slug');

            // Clear computed property cache
            unset($this->gameCategories, $this->remainingCategories);

            $this->reset('selectedCategory');
            $this->success('Category removed successfully!');

            return true;
        } catch (\Exception $e) {
            Log::error('Error removing game category', [
                'game_id' => $this->game->id,
                'category_slug' => $slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Error removing category. Please try again.');
            return false;
        }
    }

    /**
     * Refresh categories when needed
     */
    #[On('refreshGameCategories')]
    public function refreshCategories(): void
    {
        $this->game->load('categories:id,name,slug');

        // Clear all computed property caches
        unset($this->categories, $this->gameCategories, $this->remainingCategories);
    }

    public function render()
    {
        return view('livewire.backend.admin.game-management.game.category-store', [
            'categories' => $this->categories,
            'gameCategories' => $this->gameCategories,
            'remainingCategories' => $this->remainingCategories,
        ]);
    }
}
