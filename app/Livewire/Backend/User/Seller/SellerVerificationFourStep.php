<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\AccountType;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellerVerificationFourStep extends Component
{
    public $accountType;

    public $first_name;
    public $last_name;
    public $dob;
    
    public $dob_day, $dob_month, $dob_year;

    public $nationality;
    public $address;
    public $city;
    public $country_id;
    public $postal_code;

    public $company_name;
    public $company_address;
    public $company_city;
    public $company_country_id;
    public $company_postal_code;
    public $company_license_number;
    public $company_tax_number;



    public function render()
    {
        $data = Session::get('kyc_'.user()->id);
        if($data && isset($data['account_type'])){
            $this->accountType = $data['account_type'];
        }

        return view('livewire.backend.user.seller.seller-verification-four-step');
    }

    public function nextStep(){
        $this->validate([
            
        ]);
    
        return redirect()->route('user.seller.verification', ['step' => 5]);
    }

    protected function isIndividual(){
        return $this->accountType == AccountType::INDIVIDUAL->value;
    }
}
