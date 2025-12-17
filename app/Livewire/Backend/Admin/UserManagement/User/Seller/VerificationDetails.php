<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Seller;

use App\Services\SellerProfileService;
use Livewire\Component;

class VerificationDetails extends Component
{
    public $data;

    protected $id;

    protected SellerProfileService $service;

    public function boot(SellerProfileService $service){
        $this->service = $service;
    }
    public function mount($encryptedId)
    {
        $this->id = decrypt($encryptedId);

        $this->data = $this->service->findData($this->id);
    }
    public function render()
    {
        return view('livewire.backend.admin.user-management.user.seller.verification-details');
    }
}
