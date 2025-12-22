<?php

namespace App\Http\Controllers\Backend\User\OfferManagement;

use App\Http\Controllers\Controller;

class BulkUploadController extends Controller
{
    protected $masterView = 'backend.user.pages.offer-management.bulk-upload';

    public function category()
    {
        return view($this->masterView);
    }
}
