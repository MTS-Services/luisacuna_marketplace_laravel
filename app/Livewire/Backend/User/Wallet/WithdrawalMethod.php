<?php

namespace App\Livewire\Backend\User\Wallet;

use Livewire\Component;
use App\Enums\ActiveInactiveEnum;
use App\Services\WithdrawalMethodService;

class WithdrawalMethod extends Component
{

    protected WithdrawalMethodService $withdrawalMethodService;

    public function boot(WithdrawalMethodService $withdrawalMethodService)
    {
        $this->withdrawalMethodService = $withdrawalMethodService;
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
