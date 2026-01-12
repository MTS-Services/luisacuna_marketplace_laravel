<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\UserMethod;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\UserWithdrawalAccount;
use App\Traits\Livewire\WithNotification;
use App\Services\UserWithdrawalAccountService;

class Show extends Component
{
    use WithNotification;

    public bool $showModal = false;

    public UserWithdrawalAccount $data;
    public $note;


    protected UserWithdrawalAccountService $service;

    public function boot(UserWithdrawalAccountService $service)
    {
        $this->service = $service;
    }
    public function mount(UserWithdrawalAccount $data): void
    {
        $this->data = $data;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->note = null;
         $this->data->refresh();

    }


    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.user-method.show');
    }

    public function makeVerified($encryptedId): void
    {

        $id = decrypt($encryptedId);
        $data['audit_by'] = admin()->id;

        try {

            $this->service->verifyAccount($id, $data);

            $this->success('User method verified successfully.');

            $this->data->refresh();
        } catch (\Exception $e) {
            $this->error('Failed to verify user method');
            Log::error('Error verifying user method: ' . $e->getMessage());
        }
    }
    public function makeRejected($encryptedId): void
    {

        $id = decrypt($encryptedId);
        $data['audit_by'] = admin()->id;

        try {

            $this->service->rejectAccount($id, $this->note, $data);

            $this->success('User method unverified successfully.');
            $this->note = null;
            $this->data->refresh();
            $this->showModal = false;
        } catch (\Exception $e) {
            $this->error('Failed to unverify user method');
            Log::error('Error unverifying user method: ' . $e->getMessage());
        }
    }
}
