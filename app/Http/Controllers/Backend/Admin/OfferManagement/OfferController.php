<?php

namespace App\Http\Controllers\Backend\Admin\OfferManagement;

use App\Http\Controllers\Controller;
use App\Services\OfferItemService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $masterView = 'backend.admin.pages.offer-management.offer-item';

    public function __construct(protected OfferItemService $service) {}

    public function index()
    {
        return view($this->masterView);
    }
}
