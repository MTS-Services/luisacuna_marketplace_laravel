<?php

namespace App\Livewire\Frontend;

use App\Enums\FaqType;
use App\Livewire\Frontend\Frontend\Faq;
use App\Services\FaqService;
use Livewire\Component;
use App\Services\GameService;

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

    public $content = '<p>This is the initial content of the editor.</p>';

    protected GameService $gameService;
    protected FaqService $faqService;
    public function boot(GameService $gameService, FaqService $faqService)
    {
        $this->gameService = $gameService;
        $this->faqService = $faqService;
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
        return view('livewire.frontend.home', [
            'games' => $games,
        ]);
    }
}
