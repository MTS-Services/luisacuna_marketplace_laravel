<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Enums\ActiveInactiveEnum;
use App\Services\UserWithdrawalAccountService;
use App\Services\WithdrawalMethodService;
use Livewire\Component;

class WithdrawalMethod extends Component
{
    protected WithdrawalMethodService $withdrawalMethodService;

    protected UserWithdrawalAccountService $accountService;

    public bool $showModal = false;

    public bool $isLoading = false;

    public $selectedMethod = null;

    public $accountData = null;

    public function boot(WithdrawalMethodService $withdrawalMethodService, UserWithdrawalAccountService $accountService)
    {
        $this->withdrawalMethodService = $withdrawalMethodService;
        $this->accountService = $accountService;
    }

    public function openModal($accountId)
    {
        $this->showModal = true;
        $this->isLoading = true;
        $this->selectedMethod = null;

        // Fetch data
        $this->accountData = $this->accountService->findData($accountId);

        $this->isLoading = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMethod = null;
        $this->isLoading = false;
    }

    public function render()
    {
        $methods = $this->withdrawalMethodService->getAllDatas(
            'created_at',
            'desc',
            ['userWithdrawalAccounts' => function ($query) {
                $query->where('user_id', user()->id);
            }]
        )->where('status', ActiveInactiveEnum::ACTIVE->value);

        return view('livewire.backend.user.wallet.withdrawal-method', [
            'methods' => $methods,
        ]);
    }
}
