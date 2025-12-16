<?php

namespace App\Livewire\Backend\User\Seller;

use Livewire\Component;


class SellerVerification extends Component
{
    
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