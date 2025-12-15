<?php

namespace App\Livewire\Backend\User\Seller;

use App\Services\SellerKycService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class SellerVerificationFiveStep extends Component
{
    use WithFileUploads;

    public $accountType;
    public $front_image;
    public $data;

    protected SellerKycService $service;
    public function boot(SellerKycService $service){
        $this->service = $service;
    }
    public function mount(){
        $data = Session::get('kyc_'.user()->id);
        if($data && isset($data['account_type'])){
            $this->accountType = $data['account_type'];
        }
        $this->data = $data;
    }
    public function render()
    {
        
        return view('livewire.backend.user.seller.seller-verification-five-step');
    }
    public function nextStep(){

        $this->validate([
            'front_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240',
        ]);
        
        $this->data = array_merge($this->data, ['front_image' => $this->front_image]);
    //    dd($this->data);
       try{
         $record =  $this->service->createData($this->data);
       }catch( \Exception $e){
        dd($e->getMessage());
       }
        // Session::forget('kyc_'.user()->id);
        // session()->save();

    }
}
