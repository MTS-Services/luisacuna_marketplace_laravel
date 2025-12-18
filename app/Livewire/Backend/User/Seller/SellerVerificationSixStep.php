<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\AccountType;
use App\Services\SellerKycService;
use App\Services\SellerProfileService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class SellerVerificationSixStep extends Component
{
    use WithFileUploads;
    public $accountType;
    //If it's not for individutal then it will use for compnay document handler with same name !!
    public $selfie_image; 
    public $data;

    

    protected SellerProfileService $service;
    public function boot(SellerProfileService $service){
        $this->service = $service;
    }
    public function mount(){
        
        $data = Session::get('kyc_'.user()->id);


        if(isset($data['account_type'])){
            $this->accountType = $data['account_type'];
            $this->data = $data;
        }
    }
    public function render()
    {
        return view('livewire.backend.user.seller.seller-verification-six-step');
    }

    public function submit(){
        $this->validate([
           'selfie_image' => 'required|mimes:jpg,jpeg,png,gif,svg,heic,pdf,docx|max:10240',
        ]);
         $data = $this->getUploadableData();     
            $this->service->createData($data);
            session()->forget('kyc_'.user()->id);
            return redirect()->route('user.seller.verification', ['step' => 0]);
 
    }

    protected function getUploadableData(){
        if($this->isIndividual())
        {
            return [
                'account_type' => $this->data['account_type'],
                'categories' => $this->data['categories'],
                'is_experienced_seller' => $this->data['seller_experience'],
                'first_name' => $this->data['first_name'],
                'last_name' => $this->data['last_name'],
                'date_of_birth' => $this->data['dob'],
                'nationality' => $this->data['nationality'],
                'street_address' => $this->data['address'],
                'city' => $this->data['city'],
                'country_id' => $this->data['country_id'],
                'postal_code' => $this->data['postal_code'],
                'identification' => $this->data['front_image'],
                'selfie_image' => $this->selfie_image,
            ];
        }else{
            return [
                'account_type' => $this->data['account_type'],
                'categories' => $this->data['categories'],
                'is_experienced_seller' => $this->data['seller_experience'],
                'company_name' => $this->data['company_name'],
                'street_address' => $this->data['company_address'],
                'city' => $this->data['company_city'],
                'country_id' => $this->data['company_country_id'],
                'postal_code' => $this->data['company_postal_code'],
                'company_license_number' => $this->data['company_license_number'],
                'company_tax_number' => $this->data['company_tax_number'],
                'identification' => $this->data['front_image'],
                'company_documents' => $this->selfie_image,
            ];
        }
    }
     public function previousStep(){
        $data = Session::put(
            'kyc_' . user()->id,
            array_merge(
                Session::get('kyc_' . user()->id),
                [ 
                    'nextStep' => 5,
                    'prevStep' => 4
                ]

            )
        );
        return redirect()->route('user.seller.verification', ['step' => encrypt(5)]);
    }
    
    protected function isIndividual(): bool
    {
        return $this->accountType == 0;
    }   
}
