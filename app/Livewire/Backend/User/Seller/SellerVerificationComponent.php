<?php

namespace App\Livewire\Backend\User\Seller;

use Livewire\Component;
use App\Models\SellerProfile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SellerVerificationComponent extends Component
{
    use WithFileUploads;

    // Current step
    public $currentStep = 1;
    public $showCategoryPage = true;

    // Form data
    public $accountType = 'individual';
    public $selectedCategories = [];
    public $sellingExperience = 'new';
    
    // Personal details
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

    // Company details
    public $companyName = '';
    public $companyCode = '';
    public $vatNumber = '';
    public $companyStreetAddress = '';
    public $companyCity = '';
    public $companyCountry = '';
    public $companyPostalCode = '';

    // Documents
    public $idDocument;
    public $companyDocuments = [];

    // Available options
    public $categories = [
        'currency' => 'Currency',
        'accounts' => 'Accounts',
        'items' => 'Items',
        'top_ups' => 'Top Ups',
        'boosting' => 'Boosting',
        'gift_cards' => 'Gift Cards',
    ];

    protected $rules = [
        'accountType' => 'required|in:individual,company',
        'selectedCategories' => 'required|array|min:1',
        'sellingExperience' => 'required|in:new,experienced',
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'birthYear' => 'required|numeric',
        'birthMonth' => 'required|numeric',
        'birthDay' => 'required|numeric',
        'nationality' => 'required|string',
        'streetAddress' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'country' => 'required|string',
        'postalCode' => 'required|string|max:20',
    ];

    public function mount()
    {
        $this->showCategoryPage = true;
        $this->currentStep = 1;
    }

    public function selectCategory($category)
    {
        $this->showCategoryPage = false;
        $this->currentStep = 0; // Show verification required page
    }

    public function startVerification()
    {
        $this->currentStep = 1; // Start actual verification steps
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate(['accountType' => 'required']);
        } elseif ($this->currentStep == 2) {
            $this->validate(['selectedCategories' => 'required|array|min:1']);
        } elseif ($this->currentStep == 3) {
            $this->validate(['sellingExperience' => 'required']);
        } elseif ($this->currentStep == 4) {
            if ($this->accountType === 'individual') {
                $this->validate([
                    'firstName' => 'required',
                    'lastName' => 'required',
                    'birthYear' => 'required',
                    'birthMonth' => 'required',
                    'birthDay' => 'required',
                    'nationality' => 'required',
                    'streetAddress' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'postalCode' => 'required',
                ]);
            } else {
                $this->validate([
                    'companyName' => 'required',
                    'companyCode' => 'required',
                    'companyStreetAddress' => 'required',
                    'companyCity' => 'required',
                    'companyCountry' => 'required',
                    'companyPostalCode' => 'required',
                ]);
            }
        } elseif ($this->currentStep == 5) {
            $this->validate(['idDocument' => 'required|image|max:10240']);
        }

        $this->currentStep++;
        
        // If individual and reached step 6, submit directly
        if ($this->accountType === 'individual' && $this->currentStep == 6) {
            $this->submit();
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit()
    {
        try {
            $data = [
                'user_id' => user()->id,
                'account_type' => $this->accountType,
                'categories' => $this->selectedCategories,
                'selling_experience' => $this->sellingExperience,
            ];

            // Personal details
            if ($this->accountType === 'individual') {
                $data['first_name'] = $this->firstName;
                $data['middle_name'] = $this->middleName;
                $data['last_name'] = $this->lastName;
                $data['date_of_birth'] = "{$this->birthYear}-{$this->birthMonth}-{$this->birthDay}";
                $data['nationality'] = $this->nationality;
                $data['street_address'] = $this->streetAddress;
                $data['city'] = $this->city;
                $data['country'] = $this->country;
                $data['postal_code'] = $this->postalCode;
            }

            // Company details
            if ($this->accountType === 'company') {
                $data['company_name'] = $this->companyName;
                $data['company_code'] = $this->companyCode;
                $data['vat_number'] = $this->vatNumber;
                $data['company_street_address'] = $this->companyStreetAddress;
                $data['company_city'] = $this->companyCity;
                $data['company_country'] = $this->companyCountry;
                $data['company_postal_code'] = $this->companyPostalCode;
            }

            // Upload ID document
            if ($this->idDocument) {
                $data['id_document_path'] = $this->idDocument->store('seller-documents', 'public');
            }

            // Upload company documents
            if (!empty($this->companyDocuments) && $this->accountType === 'company') {
                $uploadedDocs = [];
                foreach ($this->companyDocuments as $doc) {
                    $uploadedDocs[] = $doc->store('company-documents', 'public');
                }
                $data['company_documents'] = $uploadedDocs;
            }

            SellerProfile::create($data);

            session()->flash('success', 'Seller verification submitted successfully!');
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.backend.user.seller.seller-verification-component');
    }
}