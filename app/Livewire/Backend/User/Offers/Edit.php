<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\ProductService;
use Livewire\Component;

class Edit extends Component
{

    public $offer;

    protected ProductService $service;
    public function boot(ProductService $service){
        $this->service = $service;
    }

    public function mount($encrypted_id){

        $this->offer = $this->service->findData($encrypted_id);

    }
    public function render()
    {
        return view('livewire.backend.user.offers.edit');
    }
}
