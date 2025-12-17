<?php

namespace App\Livewire\Backend\User\Seller;

use App\Models\SellerProfile;
use App\Services\SellerProfileService;
use Livewire\Component;


class SellerVerification extends Component
{
    

    protected SellerProfileService $service;

    public ?SellerProfile $sellerProfile ;
    public function boot(SellerProfileService $service){

        $this->service = $service;
    }
    public function  mount(){

       $this->sellerProfile = $this->service->findData(user()->id, 'user_id');
    }
    public function render()
    {
        return view('livewire.backend.user.seller.seller-verification');
    }

    public function startVerification(){

        session()->put('kyc_'.user()->id, [
            'nextStep' => 1,
            'prevStep' => 0
        ]);

        return redirect()->route('user.seller.verification', ['step' => encrypt(1)]);
    }
}