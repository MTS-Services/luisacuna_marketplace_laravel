<?php

namespace App\Livewire\Frontend;

use App\Enums\FaqType;
use Livewire\Component;
use App\Services\TagService;
use App\Services\GameService;
use App\Services\HeroService;
use App\Services\ProductService;
use App\Services\PlatformService;

class Home extends Component
{

    public $input;
    public $email;
    public $password;
    public $disabled;

    public $standardSelect;
    public $disabledSelect;
    public $select2Single;
    public $select2Multiple;
    public $game;
    public $platforms;
    public $perPage = 2;
    public $categorySlug;
    public $gameSlug;
    protected $datas;


    public $faqs_type = FaqType::BUYER->value;

    protected GameService $gameService;

    protected HeroService $heroService;
    protected TagService $tagService;
    protected ProductService $productService;
    protected PlatformService $platformService;

    public function boot(GameService $gameService, HeroService $heroService, TagService $tagService, PlatformService $platformService, ProductService $productService,)
    {
        $this->tagService = $tagService;
        $this->gameService = $gameService;
        $this->heroService = $heroService;
        $this->productService = $productService;
        $this->platformService = $platformService;
    }

    public function mount($gameSlug = null, $categorySlug = null)
    {

        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;

        // Load game data with relations
        // $this->game = $this->gameService->findData($gameSlug, 'slug')->load(['gameConfig', 'tags']);

        // Fetch product datas
        $this->datas = $this->getDatas();

    }


    public function getDatas()
    {
        return $this->productService->getPaginatedData($this->perPage, [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'relations' => ['games', 'category'],
        ]);
    }


    public function render()
    {


        $heros = $this->heroService->getAllDatas();

        $tag = $this->tagService->findData('popular', 'slug');

        //Popular Games 
        // Only Take 6 datas    
        $popular_games = $tag?->games()->with(['categories', 'gameTranslations' => function ($query) {
            $query->where('language_id', get_language_id());
        }])->latest()->take(6)->get();


        // Only Paginate 12 Datas
        $new_bostings = $this->gameService->paginateDatas(12, [
            'categorySlug' => 'boosting',
            'relations' => ['categories'],
        ]);


        return view('livewire.frontend.home', [
            'popular_games' => $popular_games,
            'heros' => $heros,
            'datas' => $this->datas,
            'new_bostings' => $new_bostings,

        ]);
    }
}
