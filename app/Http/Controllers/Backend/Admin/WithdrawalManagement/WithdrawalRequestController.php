<?php

namespace App\Http\Controllers\Backend\Admin\WithdrawalManagement;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;

class WithdrawalRequestController extends Controller
{
    public $master = 'backend.admin.pages.withdrawal-management.withdrawal-request';

    public function index()
    {
        return view($this->master);
    }

    public function show(string $id)
    {
        $data = WithdrawalRequest::query()->find(decrypt($id));

        if (! $data) {
            abort(404);
        }

        return view($this->master, [
            'data' => $data,
        ]);
    }
}
