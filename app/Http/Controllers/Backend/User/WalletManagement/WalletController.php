<?php

namespace App\Http\Controllers\Backend\User\WalletManagement;

use App\Http\Controllers\Controller;
use App\Services\WithdrawalMethodService;
use Illuminate\Http\Request;

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
            'data' => $data
        ]);
    }
}
