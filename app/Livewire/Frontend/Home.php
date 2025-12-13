<?php

namespace App\Livewire\Frontend;

use App\Enums\FaqType;
use Livewire\Component;
use App\Services\FaqService;
use App\Services\TagService;
use App\Services\GameService;
use App\Services\HeroService;
use App\Services\ProductService;
use App\Services\PlatformService;

class Home extends Component
{

    public $faqs_seller;
    public  $faqs_buyer;
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


    protected GameService $gameService;
    protected FaqService $faqService;

    protected HeroService $heroService;
    protected TagService $tagService;
    protected ProductService $productService;
    protected PlatformService $platformService;
    public function boot(GameService $gameService, HeroService $heroService, TagService $tagService,  FaqService $faqService, PlatformService $platformService, ProductService $productService,)
    {
        $this->tagService = $tagService;
        $this->gameService = $gameService;
        $this->faqService = $faqService;
        $this->heroService = $heroService;
        $this->productService = $productService;
        $this->platformService = $platformService;
    }

    public function mount($gameSlug = null, $categorySlug = null)
    {
        $faqs = $this->getFaqs();

        $this->faqs_buyer =  $faqs->filter(function ($faq) {
            return $faq->type == FaqType::BUYER;
        });

        $this->faqs_seller =  $faqs->filter(function ($faq) {
            return $faq->type == FaqType::SELLER;
        });

        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;

        // Load game data with relations
        // $this->game = $this->gameService->findData($gameSlug, 'slug')->load(['gameConfig', 'tags']);

        // Fetch product datas
        $this->datas = $this->getDatas();

        $this->platforms = $this->platformService->getAllDatas() ?? [];
    }
    public function saveContent()
    {
        dd($this->content);
    }
    public function saveContent2()
    {
        dd($this->content);
    }

    // public $faqType = "buyer";
    public function getFaqs()
    {
        return $this->faqService->getActiveData();
    }
public function getDatas(){
    return $this->productService->getPaginatedData($this->perPage, [
        'gameSlug' => $this->gameSlug,
        'categorySlug' => $this->categorySlug,
    ]);
}


    public function render()
    {

        $games = $this->gameService->getAllDatas();
        $heros = $this->heroService->getAllDatas();

        $tag = $this->tagService->findData('popular', 'slug');

        $games = $tag->games()->latest()->take(6)->get();
        $games->load('categories');


        return view('livewire.frontend.home', [
            'games' => $games,
            'heros' => $heros,
            'datas' => $this->datas,
        ]);
    }
}
