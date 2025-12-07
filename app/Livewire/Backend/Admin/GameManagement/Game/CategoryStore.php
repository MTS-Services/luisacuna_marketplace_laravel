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
    public ?string $selectedCategoryToRemove = null;
    public bool $showRemoveModal = false;

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
        $this->validate([
            'selectedCategory' => 'required|string|exists:categories,slug'
        ]);

        $category = $this->categoryService->findData($this->selectedCategory, 'slug');

        if (!$category) {
            $this->error('Category not found');
            return;
        }

        // Check if category is already assigned
        if ($this->gameCategories->contains('id', $category->id)) {
            $this->warning('Category is already assigned to this game');
            return;
        }

        try {
            $this->gameService->saveGameCategory($this->game, $category);

            // Refresh the relationship efficiently
            $this->game->load('categories:id,name,slug');

            // Clear computed property cache
            unset($this->gameCategories, $this->remainingCategories);

            $this->reset('selectedCategory');
            // $this->success('Category assigned successfully!');
        } catch (\Exception $e) {
            Log::error('Error assigning category', [
                'game_id' => $this->game->id,
                'category_slug' => $this->selectedCategory,
                'error' => $e->getMessage(),
            ]);

            $this->error('Error assigning category. Please try again.');
        }
    }

    #[On('confirmRemoveGameCategory')]
    public function confirmRemoveGameCategory(string $slug): void
    {
        $this->selectedCategoryToRemove = $slug;
        $this->showRemoveModal = true;
    }

    public function removeCategory(): void
    {
        if (!$this->selectedCategoryToRemove) {
            $this->error('No category selected for removal');
            return;
        }

        try {
            $category = $this->categoryService->findData($this->selectedCategoryToRemove, 'slug');

            if (!$category) {
                $this->error('Category not found');
                $this->closeRemoveModal();
                return;
            }

            // Check if category is assigned
            if (!$this->gameCategories->contains('id', $category->id)) {
                $this->warning('Category is not assigned to this game');
                $this->closeRemoveModal();
                return;
            }

            $this->gameService->deleteGameCategory($this->game, $category);

            // Refresh the relationship efficiently
            $this->game->load('categories:id,name,slug');

            // Clear computed property cache
            unset($this->gameCategories, $this->remainingCategories);

            // $this->success('Category removed successfully!');
            $this->closeRemoveModal();
        } catch (\Exception $e) {
            Log::error('Error removing game category', [
                'game_id' => $this->game->id,
                'category_slug' => $this->selectedCategoryToRemove,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Error removing category. Please try again.');
            $this->closeRemoveModal();
        }
    }

    public function closeRemoveModal(): void
    {
        $this->showRemoveModal = false;
        $this->selectedCategoryToRemove = null;
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