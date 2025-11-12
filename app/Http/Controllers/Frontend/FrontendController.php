<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
     protected $masterView = 'frontend.pages.frontend';

        public function buy()
        {
            return view($this->masterView);
        }

        public function buyer()
        {
            return view($this->masterView);
        }

        public function sell()
        {
            return view($this->masterView);
        }

        public function seller()
        {
            return view($this->masterView);
        }

        public function faq()
        {
            return view($this->masterView);
        }

}
