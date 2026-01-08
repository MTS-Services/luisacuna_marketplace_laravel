<?php

namespace App\Livewire\Frontend\Partials;

use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Services\FaqService;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Faq extends Component
{

    public $faqs_type;

    public $perPage = 20; 

    #[Locked]
    public string $routeName;

    protected FaqService $service;

    public function boot(FaqService $service)
    {
        $this->service = $service;
    }
    public function mount()
    {
        $this->faqs_type = 'buyer';
        $this->routeName = request()->route()->getName();
    }

    public function getFaqs()
    {
        if(! $routeName = 'faq') $this->perPage = 5 ;
        
        return $this->service->getPaginatedData(20, [
            'status' => FaqStatus::ACTIVE,
            'type' => $this->faqs_type == 'buyer' ? FaqType::BUYER : FaqType::SELLER,
        ]);
    }

    public function render()
    {
        $faqs = $this->getFaqs();
        return view('livewire.frontend.partials.faq', [
            'faqs' => $faqs,
        ]);
    }
}
