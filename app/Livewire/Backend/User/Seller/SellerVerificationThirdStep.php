<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\SellerExperience;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellerVerificationThirdStep extends Component
{
    public $selling_experience;


    public function render()
    {
        $data = Session::get('kyc_'.user()->id);
        if($data && isset($data['selling_experience'])){
            $this->selling_experience = $data['selling_experience'];
        }
        // dd($data);
        return view('livewire.backend.user.seller.seller-verification-third-step', [

            'sellingExperiences' => SellerExperience::options()
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
        ['selling_experience' => $this->selling_experience]));
        return redirect()->route('user.seller.verification', ['step' => 4]);
    }
}
