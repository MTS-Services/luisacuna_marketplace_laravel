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

     #[Url(keep: true)]
    public $activeTab = 'currency';


    public $game_id;

    public $list_type = 'list_grid';

     protected GameService $gameService;

     protected ProductService $productService;
     
     protected CategoryService $categoryService ;
  
     #[Locked]
     public int $userId;
    public function boot(GameService $gameService, ProductService $productService, CategoryService $categoryService)
    {

        $this->gameService = $gameService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function mount(User $user){

        $this->userId = $user->id; 

     
    }
    public function render()
    {  
        $this->list_type = $this->categoryService->findData($this->activeTab, 'slug')->layout->value;
       
        $products = $this->getProducts();

        $games = $this->gameService->randomData(100);
        
        $this->paginationData($products);

        // dd($products);
        return view('livewire.backend.user.profile.profile-category-items', [
            'products' => $products,
            'games' => $games,
            
        ]);
    }

    protected function getProducts(){
       return $this->productService->getPaginatedData($this->perPage, [
            'categorySlug' => $this->activeTab,
            'relations' => ['games'], 
            'user_id' => $this->userId,
            'game_id' => $this->game_id,
            'productTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }
        ]);
    }
}
