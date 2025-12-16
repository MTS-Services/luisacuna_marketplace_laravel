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

        $key = 'kyc_'.user()->id;

        $data = Session::get($key, []);

        if (($data['account_type'] ?? null) !== $this->account_type) {
            $data = [];
        }

        $data = array_merge($data, ['account_type' => $this->account_type]);

        Session::put($key, $data);
       
       return redirect()->route('user.seller.verification', ['step' => 2]);
    }
}
