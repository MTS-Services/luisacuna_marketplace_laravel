<?php

namespace App\Livewire\Frontend\Frontend;

use App\Enums\FaqType;
use App\Services\FaqService;
use Livewire\Component;

class Faq extends Component
{
    public $faqs_buyer ;
    public $faqs_seller;
    protected FaqService $service;
    public function boot(FaqService $service){

        $this->service = $service;

    }
    public function mount(){

      $faq =  $this->getActiveFaq();

      $this->faqs_buyer =  $faq->filter(function ($faq) {
        return $faq->type == FaqType::BUYER;
      });

      $this->faqs_seller =  $faq->filter(function ($faq) {
         return $faq->type == FaqType::SELLER;
      });
    }

    protected function getActiveFaq(){
        
       return  $this->service->getActiveData();
    }
    public function render()
    {
       
        return view('livewire.frontend.frontend.faq');
    }
}
