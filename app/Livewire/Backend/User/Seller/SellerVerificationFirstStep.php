<?php

namespace App\Livewire\Backend\User\Seller;

use Illuminate\Support\Facades\Session;
use Livewire\Component;


class SellerVerificationFirstStep extends Component
{
    public $account_type; 

    public function mount(){
    
        $this->protectStep();

    }
    public function render()
    {
      $data = Session::get('kyc_'.user()->id);

    if ($data && isset($data['account_type'])) {
        $this->account_type = $data['account_type'];
    }

    // 0 = Individual, 1 = Company
        return view('livewire.backend.user.seller.seller-verification-first-step',[
            'accountTypes' => [
                ['value' => 0, 'label' => 'Individual'],
                ['value' => 1, 'label' => 'Company'],
            ]
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

        $data = array_merge($data, [
            'account_type' => $this->account_type,
            'step' => 1
        ]);

        Session::put($key, $data);
       
       return redirect()->route('user.seller.verification', ['step' => 2]);
    }

    public function protectStep(){
        
       $kyc = session()->get('kyc_'.user()->id);

        if (!$kyc || ($kyc['nextStep'] != 1 && $kyc['prevStep'] != 0)) {
            return redirect()->route('user.seller.verification', ['step' => 0]);
        }
    }
}
