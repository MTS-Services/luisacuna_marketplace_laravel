<?php

namespace App\Livewire\Backend\User\Seller;

use Livewire\Component;
use App\Models\SellerProfile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SellerVerificationComponent extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $showCategoryPage = true;
    public $accountType = 'individual';
    public $selectedCategories = [];
    public $sellingExperience = 'new';
    
    // Individual fields
    public $firstName = '';
    public $middleName = '';
    public $lastName = '';
    public $birthYear = '';
    public $birthMonth = '';
    public $birthDay = '';
    public $nationality = '';
    public $streetAddress = '';
    public $city = '';
    public $country = '';
    public $postalCode = '';

    // Company fields
    public $companyName = '';
    public $companyCode = '';
    public $vatNumber = '';
    public $companyStreetAddress = '';
    public $companyCity = '';
    public $companyCountry = '';
    public $companyPostalCode = '';

    // Documents
    public $idDocument;
    public $selfieWithId;
    public $ultimateBeneficialOwnerIdDocument;
    public $companyDocuments = [];

    public function mount()
    {
        $this->showCategoryPage = true;
        $this->currentStep = 1;
    }

    public function selectCategory($category)
    {
        $this->showCategoryPage = false;
        $this->currentStep = 0;
    }

    public function startVerification()
    {
        $this->currentStep = 1;
    }

    public function nextStep()
    {
        $validated = $this->validateCurrentStep();
        
        if ($validated) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                return $this->validateStep1();
            case 2:
                return $this->validateStep2();
            case 3:
                return $this->validateStep3();
            case 4:
                return $this->validateStep4();
            case 5:
                return $this->validateStep5();
            case 6:
                return $this->validateStep6();
            default:
                return true;
        }
    }

    private function validateStep1()
    {
        $this->validate([
            'accountType' => 'required|in:individual,company'
        ]);
        return true;
    }

    private function validateStep2()
    {
        $this->validate([
            'selectedCategories' => 'required|array|min:1'
        ], [
            'selectedCategories.required' => 'Please select at least one category',
            'selectedCategories.min' => 'Please select at least one category'
        ]);
        return true;
    }

    private function validateStep3()
    {
        $this->validate([
            'sellingExperience' => 'required|in:new,experienced'
        ]);
        return true;
    }

    private function validateStep4()
    {
        // Validation temporarily disabled for debugging
        return true;
        
        // if ($this->accountType === 'individual') {
        //     $this->validate([
        //         'firstName' => 'required|string|max:255',
        //         'lastName' => 'required|string|max:255',
        //         'birthYear' => 'required|numeric',
        //         'birthMonth' => 'required|numeric',
        //         'birthDay' => 'required|numeric',
        //         'nationality' => 'required|string',
        //         'streetAddress' => 'required|string|max:255',
        //         'city' => 'required|string|max:255',
        //         'country' => 'required|string',
        //         'postalCode' => 'required|string|max:20',
        //     ]);
        // } else {
        //     $this->validate([
        //         'companyName' => 'required|string|max:255',
        //         'companyCode' => 'required|string|max:255',
        //         'companyStreetAddress' => 'required|string|max:255',
        //         'companyCity' => 'required|string|max:255',
        //         'companyCountry' => 'required|string',
        //         'companyPostalCode' => 'required|string|max:20',
        //     ]);
        // }
        // return true;
    }

    private function validateStep5()
    {
        // if ($this->accountType === 'individual') {
        //     $this->validate([
        //         // 'idDocument' => 'required|image|mimes:jpeg,jpg,png,heic|max:10240'
        //     ], [
        //         'idDocument.required' => 'Please upload your ID document',
        //         'idDocument.image' => 'ID document must be an image',
        //     ]);
        // } else {
        //     $this->validate([
        //         'ultimateBeneficialOwnerIdDocument' => 'required|image|mimes:jpeg,jpg,png,heic|max:10240'
        //     ], [
        //         'ultimateBeneficialOwnerIdDocument.required' => 'Please upload UBO ID document',
        //     ]);
        // }
        return true;
    }

    private function validateStep6()
    {
        if ($this->accountType === 'individual') {
            $this->validate([
                'selfieWithId' => 'required|image|mimes:jpeg,jpg,png,heic|max:10240'
            ], [
                'selfieWithId.required' => 'Please upload a selfie with your ID',
            ]);
        } else {
            $this->validate([
                'companyDocuments' => 'required|array|min:1',
                'companyDocuments.*' => 'file|mimes:jpeg,jpg,png,heic,pdf,docx|max:10240'
            ], [
                'companyDocuments.required' => 'Please upload company documents',
                'companyDocuments.min' => 'Please upload at least one document'
            ]);
        }
        return true;
    }

    public function submit()
    {
        try {
            $data = [
                'user_id' => user()->id,
                'account_type' => $this->accountType,
                'categories' => $this->selectedCategories,
                'selling_experience' => $this->sellingExperience,
                'status' => 'pending',
            ];

            if ($this->accountType === 'individual') {
                $data = array_merge($data, [
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
                    'date_of_birth' => "{$this->birthYear}-{$this->birthMonth}-{$this->birthDay}",
                    'nationality' => $this->nationality,
                    'street_address' => $this->streetAddress,
                    'city' => $this->city,
                    'country' => $this->country,
                    'postal_code' => $this->postalCode,
                ]);

                if ($this->idDocument) {
                    $data['id_document_path'] = $this->idDocument->store('seller-documents', 'public');
                }
                if ($this->selfieWithId) {
                    $data['selfie_with_id_path'] = $this->selfieWithId->store('seller-documents', 'public');
                }
            } else {
                $data = array_merge($data, [
                    'company_name' => $this->companyName,
                    'company_code' => $this->companyCode,
                    'vat_number' => $this->vatNumber,
                    'company_street_address' => $this->companyStreetAddress,
                    'company_city' => $this->companyCity,
                    'company_country' => $this->companyCountry,
                    'company_postal_code' => $this->companyPostalCode,
                ]);

                if ($this->ultimateBeneficialOwnerIdDocument) {
                    $data['ubo_id_document_path'] = $this->ultimateBeneficialOwnerIdDocument->store('seller-documents', 'public');
                }

                if (!empty($this->companyDocuments)) {
                    $uploadedDocs = [];
                    foreach ($this->companyDocuments as $doc) {
                        $uploadedDocs[] = $doc->store('company-documents', 'public');
                    }
                    $data['company_documents'] = json_encode($uploadedDocs);
                }
            }

            SellerProfile::create($data);

            session()->flash('success', 'Seller verification submitted successfully!');
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.user.seller.seller-verification-component');
    }
}