<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\Category;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProfileCategoryItems extends Component
{
    use WithPaginationData;

     #[Url(keep: true)]
    public $activeTab = 'currency';

    public $list_type = 'list_grid';

     protected GameService $gameService;
     protected ProductService $productService;
     protected CategoryService $categoryService ;
     protected User $user;
    public function boot(GameService $gameService, ProductService $productService, CategoryService $categoryService)
    {

        $this->gameService = $gameService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function mount(User $user){
        $this->user = $user; 
       $this->list_type = $this->categoryService->findData($this->activeTab, 'slug')->layout->value;
    }
    public function render()
    {   $products = $this->getProducts();
        $games = $this->gameService->getAllDatas();
        $this->paginationData($products);
        return view('livewire.backend.user.profile.profile-category-items', [
            'products' => $products,
            'games' => $games,
            
        ]);
    }

    protected function getProducts(){
       return $this->productService->getPaginatedData($this->perPage, [
            'categorySlug' => $this->activeTab,
            'relations' => ['games'], 
            'user_id' => $this->user->id,
        ]);
    }
}
