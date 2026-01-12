<?php

namespace App\Livewire\Backend\User\Wallet;

use Livewire\Component;
use App\Enums\ActiveInactiveEnum;
use App\Services\WithdrawalMethodService;
use Livewire\Attributes\On;

class WithdrawalMethod extends Component
{

    protected WithdrawalMethodService $withdrawalMethodService;
    public bool $showModal = false;
    public bool $isLoading = true;
    public $selectedMethod = null;

    public function boot(WithdrawalMethodService $withdrawalMethodService)
    {
        $this->withdrawalMethodService = $withdrawalMethodService;
    }

    #[On('setMethodReason')]
    public function setMethod($methodId)
    {
        // 1. Reset state to trigger loading effect immediately
        $this->isLoading = true;
        $this->selectedMethod = null;

        // 2. Fetch data
        $this->selectedMethod = $this->withdrawalMethodService->findData($methodId);

        // 3. Turn off loading
        $this->isLoading = false;

    }
    public function render()
    {
        $methods = $this->withdrawalMethodService->getAllDatas(
            'created_at',
            'desc',
            ['userWithdrawalAccounts']
        )->where('status', ActiveInactiveEnum::ACTIVE->value);

        return view('livewire.backend.user.wallet.withdrawal-method', [
            'methods' => $methods
        ]);
    }
}
