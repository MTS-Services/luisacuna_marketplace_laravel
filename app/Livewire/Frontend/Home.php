<?php

namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Services\GameService;
use App\Services\HeroService;
use App\Services\ProductService;


class Home extends Component
{

    public $perPage = 10;
    public $categorySlug;
    public $gameSlug;

    protected GameService $gameService;
    protected HeroService $heroService;
    protected ProductService $productService;

    public function boot(GameService $gameService, HeroService $heroService, ProductService $productService,)
    {

        $this->gameService = $gameService;
        $this->heroService = $heroService;
        $this->productService = $productService;
    }

    public function mount($gameSlug = null, $categorySlug = null)
    {

        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;

    }


    public function getTopSellingDatas()
    {
        return $this->productService->getPaginatedData($this->perPage, [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'relations' => ['games', 'category'],
        ]);
    }


    public function render()
    {

        $heros = $this->heroService->latestData(6);
  
        $popular_games = $this->gameService->latestData(10, [
            'tag' => 'popular',
        ]);

  
        // Only Paginate 12 Datas
        $new_bostings = $this->gameService->latestData(10, [
            'categorySlug' => 'boosting',
            'relations' => ['categories'],
        ]);
       


        return view('livewire.frontend.home', [
            'popular_games' => $popular_games,
            'heros' => $heros,
            'top_selling_products' =>  $this->getTopSellingDatas(),
            'new_bostings' => $new_bostings,
        ]);
    }
}
