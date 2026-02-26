<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProfileCategoryItems extends Component
{
    use WithPaginationData;

    public $categorySlug = null;

    #[Url]
    public $gameSlug = '';

    public $list_type = 'list_grid';

    protected GameService $gameService;
    protected ProductService $productService;
    protected CategoryService $categoryService;

    #[Locked]
    public int $userId;

    public function boot(GameService $gameService, ProductService $productService, CategoryService $categoryService)
    {
        $this->gameService = $gameService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function mount(User $user, $categorySlug)
    {
        $this->userId = $user->id;
        $this->categorySlug = $categorySlug;
    }

    public function render()
    {
        $this->list_type = $this->categoryService->findData($this->categorySlug, 'slug')->layout->value;

        $games = $this->gameService->randomData(50);

        $productsPaginator = $this->productService->getPaginatedData(1, [
            'categorySlug'        => $this->categorySlug,
            'relations'           => ['games'],
            'user_id'             => $this->userId,
            'gameSlug'            => $this->gameSlug,
            'productTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }
        ]);

        $this->paginationData($productsPaginator);

        return view('livewire.backend.user.profile.profile-category-items', [
            'games'    => $games,
            'products' => $productsPaginator,
        ]);
    }
}