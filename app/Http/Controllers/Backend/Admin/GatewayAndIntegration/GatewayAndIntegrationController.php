<?php

namespace App\Http\Controllers\Backend\Admin\GatewayAndIntegration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GatewayAndIntegrationController extends Controller
{
    protected string $masterView = 'backend.admin.pages.gateway-and-integration.master';

    public function __construct()
    {
        //
    }

    public function paymentIndex()
    {
        return view($this->masterView);
    }

    public function paymentEdit($encryptedId)
    {
        dd($encryptedId);
        return view($this->masterView);
    }
    public function widthdrawIndex()
    {
        return view($this->masterView);
    }

    public function widthdrawEdit($encryptedId)
    {
        dd($encryptedId);
        return view($this->masterView);
    }

    public function translationKeys()
    {
        return view($this->masterView);
    }
}
