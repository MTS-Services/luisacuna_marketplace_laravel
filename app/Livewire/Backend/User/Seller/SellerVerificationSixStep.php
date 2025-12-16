<?php

namespace App\Livewire\Backend\User\Seller;

use App\Enums\AccountType;
use App\Services\SellerKycService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class SellerVerificationSixStep extends Component
{
    use WithFileUploads;
    public $accountType;
    public $selfie_image; 
    public $data;

    

    protected SellerKycService $service;
    public function boot(SellerKycService $service){
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
         $this->data['selfie_image'] = $this->selfie_image;
      
        

         if(!$this->isIndividual()){
            $this->data['address'] = $this->data['company_address'];
            $this->data['city'] = $this->data['company_city'];
            $this->data['country_id'] = $this->data['company_country_id'];
            $this->data['postal_code'] = $this->data['company_postal_code'];
            unset($this->data['company_address']);
            unset($this->data['company_city']);
            unset($this->data['company_country_id']);
            unset($this->data['company_postal_code']);
         }
        // try {
            $this->service->createData($this->data);
            Session::forget('kyc_'.user()->id);
            session()->save();
            return redirect()->route('user.seller.verification', ['step' => 7]);
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
        
        // return redirect()->route('user.seller.verification', ['step' => 7]);
    }

    protected function isIndividual(): bool
    {
        return $this->accountType === AccountType::INDIVIDUAL->value;
    }   
}
