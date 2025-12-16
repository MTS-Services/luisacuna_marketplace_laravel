<?php 

namespace App\Livewire\Backend\User\Seller;
use App\Enums\AccountType;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellerVerificationFourStep extends Component
{
    // Individual
    public $accountType;
    public $first_name, $last_name;
    public $dob_year, $dob_month, $dob_day;
    public $nationality, $address, $city, $country_id, $postal_code;

    // Company
    public $company_name, $company_address, $company_city;
    public $company_country_id, $company_postal_code;
    public $company_license_number, $company_tax_number;

    public $countries = [];

    public function mount()
    {
        $this->protectStep();

        $this->countries = Country::all();

        $data = Session::get('kyc_' . user()->id);
        if (!$data) return;

        $this->accountType = $data['account_type'] ?? null;


        if ($this->isIndividual()) {
            $this->fillIndividual($data);
        } else {
            $this->fillCompany($data);
        }
    }

    public function render()
    {
        return view('livewire.backend.user.seller.seller-verification-four-step');
    }

    // ---------------- Helpers ----------------

    protected function fillIndividual(array $data): void
    {
        $this->first_name  = $data['first_name'] ?? null;
        $this->last_name   = $data['last_name'] ?? null;
        $this->nationality = $data['nationality'] ?? null;
        $this->address     = $data['address'] ?? null;
        $this->city        = $data['city'] ?? null;
        $this->country_id  = $data['country_id'] ?? null;
        $this->postal_code = $data['postal_code'] ?? null;

        if (!empty($data['dob'])) {
        $dob = Carbon::parse($data['dob']);
        $this->dob_year  = $dob->format('Y');
        $this->dob_month = $dob->format('m'); // padded string
        $this->dob_day   = $dob->format('d'); // padded string
        } else {
            $this->dob_year = $this->dob_month = $this->dob_day = null;
        }
    }

    protected function fillCompany(array $data): void
    {
        $this->company_name           = $data['company_name'] ?? null;
        $this->company_address        = $data['company_address'] ?? null;
        $this->company_city           = $data['company_city'] ?? null;
        $this->company_country_id     = $data['company_country_id'] ?? null;
        $this->company_postal_code    = $data['company_postal_code'] ?? null;
        $this->company_license_number = $data['company_license_number'] ?? null;
        $this->company_tax_number     = $data['company_tax_number'] ?? null;
    }

    protected function dob(): ?string
    {
        if ($this->dob_year && $this->dob_month && $this->dob_day) {
            return Carbon::createFromDate(
                $this->dob_year,
                $this->dob_month,
                $this->dob_day
            )->format('Y-m-d');
        }
        return null;
    }

    protected function isIndividual(): bool
    {
        return $this->accountType == 0 ;
    }

    // ---------------- Actions ----------------

    public function nextStep()
    {
        $this->validate($this->rules());

        $data = $this->isIndividual()
            ? [
                'first_name' => $this->first_name,
                'last_name'  => $this->last_name,
                'dob'        => $this->dob(),
                'nationality'=> $this->nationality,
                'address'    => $this->address,
                'city'       => $this->city,
                'country_id' => $this->country_id,
                'postal_code'=> $this->postal_code,
            ]
            : [
                'company_name'           => $this->company_name,
                'company_address'        => $this->company_address,
                'company_city'           => $this->company_city,
                'company_country_id'     => $this->company_country_id,
                'company_postal_code'    => $this->company_postal_code,
                'company_license_number' => $this->company_license_number,
                'company_tax_number'     => $this->company_tax_number,
            ];

        Session::put(
            'kyc_' . user()->id,
            array_merge(Session::get('kyc_' . user()->id, []), [...$data, 'nextStep' => 5, 'prevStep' => 4])
        );

        return redirect()->route('user.seller.verification', ['step' => encrypt(5)]);
    }

    protected function rules(): array
    {
        return $this->isIndividual()
            ? [
                'first_name' => 'required',
                'last_name'  => 'required',
                'dob_year'   => 'required',
                'dob_month'  => 'required',
                'dob_day'    => 'required',
                'nationality'=> 'required',
                'address'    => 'required',
                'city'       => 'required',
                'country_id' => 'required',
                'postal_code'=> 'required',
            ]
            : [
                'company_name' => 'required',
                'company_address' => 'required',
                'company_city' => 'required',
                'company_country_id' => 'required',
                'company_postal_code' => 'required',
                'company_license_number' => 'required',
                'company_tax_number' => 'nullable',
            ];
    }

    public function previousStep(){
        $data = Session::put(
            'kyc_' . user()->id,
            array_merge(
                Session::get('kyc_' . user()->id),
                [
                    'nextStep' => 3,
                    'prevStep' => 2
                ]

            )
        );
         return redirect()->route('user.seller.verification', ['step' => encrypt(3)]);
    }
    public function protectStep()
    {

        $kyc = session()->get('kyc_' . user()->id);

        if (!$kyc || ($kyc['nextStep'] != 4 || $kyc['prevStep'] != 3)) {
            return redirect()->route('user.seller.verification', ['step' => 0]);
        }
    }
}
