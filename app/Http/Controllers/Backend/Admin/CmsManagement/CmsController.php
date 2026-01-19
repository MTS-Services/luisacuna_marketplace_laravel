<?php

namespace App\Http\Controllers\Backend\Admin\CmsManagement;

use App\Enums\CmsType;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    protected string $masterView = 'backend.admin.pages.cms-management.cms';

    /**
     * Terms & Condition Page
     */
    public function termsCondition(): View
    {
        $type = CmsType::TERMS_CONDITION;
        return view($this->masterView, compact('type'));
    }

    /**
     * Refund Policy Page
     */
    public function refundPolicy(): View
    {
        $type = CmsType::REFUND_POLICY;
        return view($this->masterView, compact('type'));
    }

    /**
     * Privacy Policy Page
     */
    public function privacyPolicy(): View
    {
        $type = CmsType::PRIVACY_POLICY;
        return view($this->masterView, compact('type'));
    }
    /**
     * How to Buy Page
     */
    public function howToBuy(): View
    {
        $type = CmsType::HOW_TO_BUY;
        return view($this->masterView, compact('type'));
    }
    /**
     * Buyer Protection Page
     */
    public function buyerProtection(): View
    {
        $type = CmsType::BUYER_PROTECTION;
        return view($this->masterView, compact('type'));
    }
    /**
     * How to Sell Page
     */
    public function howToSell(): View
    {
        $type = CmsType::HOW_TO_SELL;
        return view($this->masterView, compact('type'));
    }
    /**
     * How to Sell Page
     */
    public function sellerProtection(): View
    {
        $type = CmsType::SELLER_PROTECTION;
        return view($this->masterView, compact('type'));
    }
}
