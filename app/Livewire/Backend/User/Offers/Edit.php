<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Platform;
use App\Services\PlatformService;
use App\Services\ProductService;
use Livewire\Component;

class Edit extends Component
{

    public $offer;

    public $timelineOptions = [] ; 

    public $platforms = [];


    public $delivery_timeline;

    protected ProductService $service;
    protected PlatformService $platformService;
    public function boot(ProductService $service, PlatformService $platformService){
        $this->service = $service;
        $this->platformService = $platformService;
    }

    public function mount($encrypted_id){

        $this->offer = $this->service->findData($encrypted_id);

        $this->offer->load([
            'game.gameConfig' => function ($query) {
                $query->where('category_id', $this->offer->category_id);
            },
            'category',
        ]);

        $this->platforms = $this->platformService->getActiveData();

    }


        public function updatedDeliveryMethod($deliveryMethod)
    {
        // Update timeline options based on delivery method
        if ($deliveryMethod === 'manual') {
            $this->timelineOptions = ['1 Hour', '2 Hours', '3 Hours', '4 Hours']; 
        } else {
            $this->timelineOptions = ["Instant Delivery", '1 Hour', '2 Hours', '3 Hours', '4 Hours'];
        }
        
        // Reset delivery time when method changes
        $this->delivery_timeline = null;
    }

    public function render()
    {
        return view('livewire.backend.user.offers.edit');
    }
}
