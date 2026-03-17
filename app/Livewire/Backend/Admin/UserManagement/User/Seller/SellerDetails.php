<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Seller;

use App\Services\SellerProfileService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SellerDetails extends Component
{
    use WithNotification;
    public $data;
    public string $rejectReason = '';

    protected $id;

    protected SellerProfileService $service;

    protected function rules(): array
    {
        return [
            'rejectReason' => 'required|string|min:10|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'rejectReason.required' => 'Please provide a rejection reason.',
            'rejectReason.min'      => 'Rejection reason must be at least 10 characters.',
        ];
    }

    public function boot(SellerProfileService $service)
    {
        $this->service = $service;
    }
    public function mount($encryptedId)
    {
        $this->id = decrypt($encryptedId);

        $this->data = $this->service->findData($this->id)->load('user');
    }
    public function render()
    {
        return view('livewire.backend.admin.user-management.user.seller.seller-details');
    }

    public function makeVerified($encryptedId): void
    {

        $id = decrypt($encryptedId);

        try {

            $this->service->verifyData($id);

            $this->success('Seller verified successfully.');

            $this->data->refresh();
        } catch (\Exception $e) {
            $this->error('Failed to verify seller');
            Log::error('Error verifying seller: ' . $e->getMessage());
        }
    }

    public function makeRejected($encryptedId)
    {
        $id = decrypt($encryptedId);

        try {

            $this->service->unverifyData($id);

            $this->success('Seller unverified successfully.');
            $this->data->refresh();
        } catch (\Exception $e) {
            $this->error('Failed to unverify seller');
            Log::error('Error unverifying seller: ' . $e->getMessage());
        }
    }

    public function openRejectModal(): void
    {
        $this->rejectReason = '';
        $this->resetValidation();
        $this->modal('reject-seller')->show();
    }

    public function submitRejection(): void
    {
        $this->validate();

        try {
            $this->service->rejectData($this->data->id, $this->rejectReason);
            $this->modal('reject-seller')->close();
            $this->success('Seller rejected successfully.');
            $this->rejectReason = '';
            $this->data->refresh();
        } catch (\Exception $e) {
            $this->error('Failed to reject seller.');
            Log::error('Error rejecting seller: ' . $e->getMessage());
        }
    }
}
