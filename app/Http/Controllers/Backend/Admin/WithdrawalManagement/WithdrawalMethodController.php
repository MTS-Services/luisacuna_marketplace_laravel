<?php

namespace App\Http\Controllers\Backend\Admin\WithdrawalManagement;

use App\Http\Controllers\Controller;
use App\Services\WithdrawalMethodService;
use Illuminate\Http\Request;

class WithdrawalMethodController extends Controller
{
    //
    public $master = 'backend.admin.pages.withdrawal-management.withdrawal-method';

    public function  __construct(protected WithdrawalMethodService $service)
    {
        
    }
    public function index()
    {
        return view($this->master);
    }

    public function create()
    {
        return view($this->master);
    }

    public function edit($encryptId)
    {
        $data = $this->service->findData(decrypt($encryptId));
        if (!$data) {
            abort(404,"Item Not Found");   
        }
         return view($this->master, [
            'data' => $data
         ]);
    }
}