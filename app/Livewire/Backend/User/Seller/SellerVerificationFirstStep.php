<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\AccountType;
use Illuminate\Support\Facades\Session;
use Livewire\Component;


class SellerVerificationFirstStep extends Component
{
    public $account_type; 
    public function render()
    {
      $data = Session::get('kyc_'.user()->id);

    if ($data && isset($data['account_type'])) {
        $this->account_type = $data['account_type'];
    }

        return view('livewire.backend.user.seller.seller-verification-first-step',[
            'accountTypes' => AccountType::options()
        ]);
    }

    public function nextStep()
    {
        
        $this->validate([
            'account_type' => 'required',
        ],[
            'account_type.required' => 'Please select account type',
        ]
        );
        if(Session::has('kyc_'.user()->id)){
            Session::put('kyc_'.user()->id, 
            array_merge(
                Session::get('kyc_'.user()->id),
                ['account_type' => $this->account_type]
            )
            );
        }else{
           Session::put('kyc_'.user()->id, [
           'account_type' => $this->account_type
           ]);
        }
       

       return redirect()->route('user.seller.verification', ['step' => 2]);
    }
}
