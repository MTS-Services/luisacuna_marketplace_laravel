<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CmsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    protected $masterView = 'frontend.pages.frontend';

    public function howToBuy()
    {
        return view($this->masterView);
    }

    public function buyerProtection()
    {
        return view($this->masterView);
    }

    public function howtoSell()
    {
        return view($this->masterView);
    }

    public function sellerProtection()
    {
        return view($this->masterView);
    }

    public function faq()
    {
        return view($this->masterView);
    }

    public function contactUs()
    {

        return view($this->masterView);
    }


    // public function termsAndConditions()
    // {
    //     return view($this->masterView);
    // }

    public function termsAndConditions()
    {
        $type = CmsType::TERMS_CONDITION;
        return view($this->masterView, compact('type'));
    }

    // public function refunPolicy()
    // {
    //     return view($this->masterView);
    // }

    public function refunPolicy()
    {
        $type = CmsType::REFUND_POLICY;
        return view($this->masterView, compact('type'));
    }


    // public function privacyPolicy()
    // {
    //     return view($this->masterView);
    // }

    public function privacyPolicy()
    {
        $type = CmsType::PRIVACY_POLICY;
        return view($this->masterView, compact('type'));
    }
}
