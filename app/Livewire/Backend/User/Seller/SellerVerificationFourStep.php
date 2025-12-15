<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\AccountType;
use App\Models\Country;
use Illuminate\Support\Carbon;
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

    public Country $country; // it's model
    public function boot(Country $country){
        $this->country = $country ;
    }

    public function render()
    {
        $data = Session::get('kyc_'.user()->id);
        if($data){
                $this->accountType = $data['account_type'] ?? null;
                if($this->accountType === 'individual'){
                 $this->first_name = $data['first_name'] ?? null;
                 $this->last_name = $data['last_name'] ?? null;
                 $this->dob_year = Carbon::createFromDate($data['dob'])->format('Y') ?? null;
                 $this->dob_month = Carbon::createFromDate($data['dob'])->format('m') ?? null;
                 $this->dob_day = Carbon::createFromDate($data['dob'])->format('d') ?? null;
                 $this->nationality = $data['nationality'] ?? null;
                 $this->address = $data['address'] ?? null;
                 $this->city = $data['city'] ?? null;
                 $this->postal_code = $data['postal_code'] ?? null;
                 $this->country_id = $data['country_id'] ?? null;
                }else{
                 $this->first_name = null;
                 $this->last_name =  null;
                 $this->dob_year =  null;
                 $this->dob_month =  null;
                 $this->dob_day = null;
                 $this->nationality =  null;
                 $this->address =  null;
                 $this->city =  null;
                 $this->postal_code =  null;
                 $this->country_id =  null;
                }
             

                $this->company_address = $data['company_address'] ?? null;
                $this->company_city = $data['company_city'] ?? null;
                $this->company_country_id = $data['company_country_id'] ?? null;
                $this->company_postal_code = $data['company_postal_code'] ?? null;
                $this->company_license_number = $data['company_license_number'] ?? null;
                $this->company_tax_number = $data['company_tax_number'] ?? null;   
        }

        $countries = $this->country->all();

        return view('livewire.backend.user.seller.seller-verification-four-step',[
            'countries' => $countries
        ]);
    }

    public function nextStep(){

        $rules = [];

        if($this->isIndividual()){
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'dob_day' => 'required',
                'dob_year' => 'required',
                'dob_month' => 'required',
                'nationality' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country_id' => 'required',
                'postal_code' => 'required',
            ];
        }else{
            $rules = [
                'company_name' => 'required',
                'company_address' => 'required',
                'company_city' => 'required',
                'company_country_id' => 'required',
                'company_postal_code' => 'required',
                'company_license_number' => 'required',
                'company_tax_number' => 'nullable',
            ];
        }

         $this->validate($rules);
        $data = [];
        if($this->isIndividual()){
            $data =  [
                'first_name' => $this->first_name ?? null,
                'last_name' => $this->last_name ?? null,
                'dob' => $this->dob() ,
                'nationality' => $this->nationality ?? null,
                
                'address' => $this->address ?? $this->company_address ?? null,
                'city' => $this->city ?? $this->company_city ?? null,
                'country_id' => $this->country_id ?? $this->company_country_id ?? null,
                'postal_code' => $this->postal_code ?? $this->company_postal_code ?? null,
                'company_license_number' => $this->company_license_number ?? null,
                'company_tax_number' => $this->company_tax_number ?? null,
            ];
        }else{
            $data = [
                'company_name' => $this->company_name ?? null,
                'company_address' => $this->company_address ?? null,
                'company_city' => $this->company_city ?? null,
                'company_country_id' => $this->company_country_id ?? null,
                'company_postal_code' => $this->company_postal_code ?? null,
                'company_license_number' => $this->company_license_number ?? null,
                'company_tax_number' => $this->company_tax_number ?? null,
            ];
        }
        if(Session::has('kyc_'.user()->id)){
            Session::put('kyc_'.user()->id, 
            array_merge(
                Session::get('kyc_'.user()->id),
                $data
            )
            );
        }
        if(Session::has('kyc_'.user()->id)){
            Session::put('kyc_'.user()->id, 
            array_merge(
                Session::get('kyc_'.user()->id),
               
            )
            );
        }

    
        return redirect()->route('user.seller.verification', ['step' => 5]);
    }

    protected function dob(){
        dd($this->dob_year,$this->dob_month,$this->dob_day);
        if($this->dob_year != null && $this->dob_month != null && $this->dob_day != null){
         return Carbon::createFromDate($this->dob_year,$this->dob_month,$this->dob_day)->format('Y-m-d');   
        }

      return null;

    }
    protected function isIndividual(){
        return $this->accountType == AccountType::INDIVIDUAL->value;
    }
}
