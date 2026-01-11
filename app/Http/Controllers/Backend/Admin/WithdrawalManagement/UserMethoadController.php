<?php

namespace App\Http\Controllers\Backend\Admin\WithdrawalManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserWithdrawalAccountService;

class UserMethoadController extends Controller
{
    public $master = 'backend.admin.pages.withdrawal-management.user-method';

    public function  __construct(protected UserWithdrawalAccountService $service) {}

    public function index()
    {
        return view($this->master);
    }

    public function show(string $id)
    {
        $data = $this->service->findData(decrypt($id));
        if (!$data) {
            abort(404);
        }
        return view($this->master, [ 
            'data' => $data
        ]);
    }
}
