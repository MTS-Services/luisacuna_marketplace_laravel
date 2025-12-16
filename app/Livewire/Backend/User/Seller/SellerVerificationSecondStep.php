<?php

namespace App\Livewire\Backend\User\Seller;

use App\Services\CategoryService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellerVerificationSecondStep extends Component
{

    public array $selectedCategories = [];

    protected CategoryService $categoryService;
    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function mount(){
        $this->protectStep();
    }
    public function render()
    {
        $data = Session::get('kyc_' . user()->id);

        if ($data && isset($data['categories'])) {
            $this->selectedCategories = $data['categories'];
        }
        $categories = $this->getCategories();
        return view('livewire.backend.user.seller.seller-verification-second-step', compact('categories'));
    }

    protected function getCategories()
    {

        return $this->categoryService->getDatas()->pluck('name', 'id')->toArray();
    }

    public function nextStep()
    {
        $this->validate([
            'selectedCategories' => 'required|array|min:1',
        ]);

        $data = Session::put(
            'kyc_' . user()->id,
            array_merge(
                Session::get('kyc_' . user()->id),
                [
                    'categories' => $this->selectedCategories,
                    'nextStep' => 3,
                    'prevStep' => 2
                ]

            )
        );

        return redirect()->route('user.seller.verification', ['step' => encrypt(3)]);
    }
    public function previousStep(){
        $data = Session::put(
            'kyc_' . user()->id,
            array_merge(
                Session::get('kyc_' . user()->id),
                [
                    'nextStep' => 1,
                    'prevStep' => 0
                ]

            )
        );
        return redirect()->route('user.seller.verification', ['step' => encrypt(1)]);
    }

    public function protectStep()
    {

        $kyc = session()->get('kyc_' . user()->id);

        if (!$kyc || ($kyc['nextStep'] != 2 ||  $kyc['prevStep'] != 1)) {
            return redirect()->route('user.seller.verification', ['step' => 0]);
        }
    }
}
