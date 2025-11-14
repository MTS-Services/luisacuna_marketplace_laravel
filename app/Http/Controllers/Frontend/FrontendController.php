<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

}

