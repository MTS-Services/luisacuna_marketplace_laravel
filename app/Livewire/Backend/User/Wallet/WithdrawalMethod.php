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

    public bool $showWithdrawalModal = false;

    public ?int $selectedMethodId = null;

    public ?string $withdrawalAmount = null;

    public ?string $withdrawalNote = null;

    public bool $methodLocked = false;

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

    public function openWithdrawalModal(?int $methodId = null): void
    {
        $this->resetWithdrawalForm();
        $this->selectedMethodId = $methodId;
        $this->methodLocked = filled($methodId);
        $this->showWithdrawalModal = true;
    }

    public function closeWithdrawalModal(): void
    {
        $this->showWithdrawalModal = false;
        $this->methodLocked = false;
    }

    public function submitWithdrawalRequest(): void
    {
        $this->validate([
            'selectedMethodId' => 'required|integer|exists:withdrawal_methods,id',
            'withdrawalAmount' => 'required|numeric|min:1',
            'withdrawalNote' => 'nullable|string|max:500',
        ]);

        // TODO: hook into actual withdrawal request workflow once available
        session()->flash('success', 'Your withdrawal request has been submitted.');

        $this->closeWithdrawalModal();
    }

    protected function resetWithdrawalForm(): void
    {
        $this->resetValidation();
        $this->selectedMethodId = null;
        $this->withdrawalAmount = null;
        $this->withdrawalNote = null;
        $this->methodLocked = false;
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
