<?php

namespace App\Livewire\Frontend\Partials;

use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Services\FaqService;
use Livewire\Component;

class Faq extends Component
{
  
    public $faqs_type;

    protected FaqService $service;
    public function boot(FaqService $service){
        $this->service = $service;
    }
    public function mount($faqs_type){
        $this->faqs_type = $faqs_type;
    }



     public function getFaqs()
    {
        return $this->service->getPaginatedData(20, [
            'status' => FaqStatus::ACTIVE,
            'type' => $this->faqs_type == 'buyer' ? FaqType::BUYER : FaqType::SELLER ,
        ]);
    }

    public function changeFaqType($type){
        $this->faqs_type = $type;
        
    }
    public function render()
    {

    
       
        return view('livewire.frontend.partials.faq',[
            'faqs' => $this->getFaqs(),
        ]);
    }
}
