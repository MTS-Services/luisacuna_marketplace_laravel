<?php

namespace App\Http\Controllers\Backend\Admin\FeeSettingsManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeeSettingsController extends Controller
{
    protected string $masterView = 'backend.admin.pages.fee-settings-management.fee-settings';


    public function feeSettings()
    {
        return view($this->masterView);
    }

}
