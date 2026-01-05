<?php

namespace App\Http\Controllers\Backend\User\OfferManagement;

use App\Http\Controllers\Controller;

class UserOfferController extends Controller
{
    protected $masterView = 'backend.user.pages.offer-management.user-offer';

    public function category($categorySlug){
        return view($this->masterView, [
            'categorySlug' => $categorySlug,
        ]);
    }
}
