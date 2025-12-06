<?php

namespace App\Livewire\Frontend;

use App\Enums\FaqType;
use App\Services\FaqService;
use Livewire\Component;
use App\Services\GameService;
use App\Services\HeroService;
use App\Services\TagService;

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



    protected GameService $gameService;
    protected FaqService $faqService;

    protected HeroService $heroService;
    protected TagService $tagService;
    public function boot(GameService $gameService, HeroService $heroService, TagService $tagService ,  FaqService $faqService)
    {
        $this->tagService = $tagService;
        $this->gameService = $gameService;
        $this->faqService = $faqService;
        $this->heroService = $heroService;
    }

    public function mount(){
        $faqs = $this->getFaqs();

        $this->faqs_buyer =  $faqs->filter(function ($faq) {
            return $faq->type == FaqType::BUYER;
        });

        $this->faqs_seller =  $faqs->filter(function ($faq) {
            return $faq->type == FaqType::SELLER;
        });

       

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

    public function render()
    {

        $games = $this->gameService->getAllDatas();
        $hero = $this->heroService->getFirstActiveData();

        $tag = $this->tagService->findData('popular', 'slug');
      
        $games = $tag->games()->latest()->take(6)->get();
        $games->load('categories');
     
      
        return view('livewire.frontend.home', [
            'games' => $games,
            'hero' => $hero,
        ]);
    }
}
