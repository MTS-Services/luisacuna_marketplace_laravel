<?php

namespace App\Livewire\Backend\User\Seller;

use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class SellerVerificationFiveStep extends Component
{
    use WithFileUploads;

    public $accountType;
    
    public function render()
    {
        $data = Session::get('kyc_'.user()->id);
        if($data && isset($data['account_type'])){
            $this->accountType = $data['account_type'];
        }
        return view('livewire.backend.user.seller.seller-verification-five-step');
    }
    public function nextStep(){


    }
}
