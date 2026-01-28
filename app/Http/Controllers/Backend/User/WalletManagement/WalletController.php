<?php

namespace App\Http\Controllers\Backend\User\WalletManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserWithdrawalAccount;
use App\Services\WithdrawalMethodService;

class WalletController extends Controller
{
    public $userMasterView;

    protected WithdrawalMethodService $withdrawalMethodService;

    public function __construct(WithdrawalMethodService $withdrawalMethodService)
    {
        $this->withdrawalMethodService = $withdrawalMethodService;
        $this->userMasterView = 'backend.user.pages.wallet.wallet';
    }

    public function wallet()
    {
        return view($this->userMasterView);
    }
    public function withdrawalMethod()
    {
        return view($this->userMasterView);
    }
    public function withdrawalForm($id)
    {
        $data = $this->withdrawalMethodService->findData(decrypt($id));
        return view($this->userMasterView, [
            'data' => $data,
        ]);
    }
    // public function withdrawalFormUpdate($id)
    // {
    //     $data = $this->withdrawalMethodService->findData(decrypt($id));
    //     return view($this->userMasterView, [
    //         'data' => $data,
    //     ]);
    // }
    // Controller
    public function withdrawalFormUpdate($account_id)
    {
        $account = UserWithdrawalAccount::findOrFail(decrypt($account_id)); 
        $method = $account->withdrawalMethod; 

        return view($this->userMasterView, [
            'method' => $method,
            'account' => $account,
        ]);
    }
}
