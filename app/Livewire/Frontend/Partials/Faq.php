<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class Faq extends Component
{
    public $faqs_buyer = [];
    public $faqs_seller = [];
    public function mount($faqs_buyer, $faqs_seller){
        $this->faqs_buyer = $faqs_buyer;
        $this->faqs_seller = $faqs_seller;
    }
    public function render()
    {
        return view('livewire.frontend.partials.faq');
    }
}
