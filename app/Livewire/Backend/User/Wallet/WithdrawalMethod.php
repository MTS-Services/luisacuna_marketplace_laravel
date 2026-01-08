<?php

namespace App\Livewire\Backend\User\Wallet;

use App\Services\WithdrawalMethodService;
use Livewire\Component;

class WithdrawalMethod extends Component
{

    protected WithdrawalMethodService $withdrawalMethodService;

    public function boot(WithdrawalMethodService $withdrawalMethodService)
    {
        $this->withdrawalMethodService = $withdrawalMethodService;
    }
    public function render()
    {
        $methods = $this->withdrawalMethodService->getAllDatas();
        return view('livewire.backend.user.wallet.withdrawal-method',[
            'methods' => $methods
        ]);
    }
}
