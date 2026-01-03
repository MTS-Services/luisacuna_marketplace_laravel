<?php

namespace App\Http\Controllers\Backend\Admin\FinanceManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected $masterView = 'backend.admin.pages.finance-management.finance';
    public function index()
    {
        return view($this->masterView);
    }

    public function topUps()
    {
        return view($this->masterView);
    }
    public function purchased()
    {
        return view($this->masterView);
    }
    public function withdrawals()
    {
        return view($this->masterView);
    }
}
