<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use App\Services\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class MultiLangController extends Controller
{
    public function __construct(
        protected LanguageService $languageService,
        protected CurrencyService $currencyService
    ) {}

    public function langChange(Request $request): RedirectResponse
    {
        $lang = $request->lang;
        $currencyCode = $request->currency;

        // Validate Language
        $activeLanguages = $this->languageService->getActiveData();
        if (!in_array($lang, $activeLanguages->pluck('locale')->toArray())) {
            abort(400);
        }

        // Validate Currency and Retrieve Symbol
        $activeCurrencies = $this->currencyService->getActiveData();
        $currencyData = $activeCurrencies->where('code', $currencyCode)->first();

        if (!$currencyData) {
            abort(400);
        }

        // Store both code and symbol in Session
        Session::put('locale', $lang);
        Session::put('currency', $currencyData->code);
        Session::put('currency_symbol', $currencyData->symbol);

        // Apply Locale immediately for the redirect response
        App::setLocale($lang);

        return redirect()->back();
    }
}
