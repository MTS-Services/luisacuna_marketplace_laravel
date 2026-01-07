<?php

namespace App\Livewire\Backend\User\Seller;

use App\Services\Cloudinary\CloudinaryService;
use App\Traits\FileManagementTrait;
use Illuminate\Foundation\Cloud;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class SellerVerificationFiveStep extends Component
{
    use WithFileUploads, FileManagementTrait;

    public $accountType;
    public $front_image;

    protected CloudinaryService $cloudinaryService;
    public function boot(CloudinaryService $cloudinaryService){
        $this->cloudinaryService = $cloudinaryService;
    }


    public function mount()
    {
        $this->protectStep();

        $data = Session::get('kyc_' . user()->id);
        if ($data && isset($data['account_type'])) {
            $this->accountType = $data['account_type'];
        }
    }
    public function render()
    {

        return view('livewire.backend.user.seller.seller-verification-five-step');
    }
    public function nextStep()
    {

        $validated = $this->validate([
            'front_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240',
        ]);

       try {
            $uploadedFile = $this->cloudinaryService->upload($validated['front_image'], ['folder' => 'seller_profiles']);
          $tempPath = $uploadedFile->publicId;
        } catch (\Exception $e) {
           $tempPath = null;
        }

        Session::put('kyc_' . user()->id, array_merge(
            Session::get('kyc_' . user()->id),
            [
                'front_image' =>  $tempPath,
                'nextStep' => 6,
                'prevStep' => 5
            ]
        ));
        return redirect()->route('user.seller.verification', ['step' => encrypt(6)]);
    }

    public function previousStep()
    {
        $data = Session::put(
            'kyc_' . user()->id,
            array_merge(
                Session::get('kyc_' . user()->id),
                [
                    'nextStep' => 4,
                    'prevStep' => 3
                ]

            )
        );
        return redirect()->route('user.seller.verification', ['step' => encrypt(4)]);
    }
    public function protectStep()
    {

        $kyc = session()->get('kyc_' . user()->id);

        if (!$kyc || ($kyc['nextStep'] != 5 ||  $kyc['prevStep'] != 4)) {
            return redirect()->route('user.seller.verification', ['step' => 0]);
        }
    }
}
