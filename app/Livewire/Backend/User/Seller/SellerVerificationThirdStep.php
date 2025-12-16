<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\SellerExperience;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellerVerificationThirdStep extends Component
{
    public $selling_experience;


    public function mount(){
        $this->protectStep();
    }
    public function render()
    {
        $data = Session::get('kyc_'.user()->id);
        if($data && isset($data['seller_experience'])){
            $this->selling_experience = $data['seller_experience'];
        }
        // dd($data);
        return view('livewire.backend.user.seller.seller-verification-third-step', [

            'sellingExperiences' => [
                ['value' => 1, 'label' => 'Experienced'],
                ['value' => 0, 'label' => 'Newbie'],
            ]
        ]);
    }

    public function nextStep(){
        $this->validate([
            'selling_experience' => 'required'
        ],[
            'selling_experience.required' => 'Please select selling experience',
        ]);
        
        $data = Session::put(
        'kyc_'.user()->id,
        array_merge(
            Session::get('kyc_'.user()->id),
        [
            'seller_experience' => $this->selling_experience, 
            'nextStep' => 4,
            'prevStep' => 3
        ]));
        return redirect()->route('user.seller.verification', ['step' => encrypt(4)]);
    }
    public function protectStep()
    {

        $kyc = session()->get('kyc_' . user()->id);

        if (!$kyc || ($kyc['nextStep'] != 3 && $kyc['prevStep'] != 2)) {
            return redirect()->route('user.seller.verification', ['step' => 0]);
        }
    }
}
