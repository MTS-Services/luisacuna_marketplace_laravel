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

    /**
     * Change language and currency
     */
    public function langChange(Request $request): RedirectResponse
    {
        $lang = $request->lang;
        $currencyCode = $request->currency;

        // Validate Language
        $activeLanguages = $this->languageService->getActiveData();
        if (!in_array($lang, $activeLanguages->pluck('locale')->toArray())) {
            abort(400, 'Invalid language');
        }

        // Validate Currency and Retrieve Symbol
        $activeCurrencies = $this->currencyService->getActiveData();
        $currencyData = $activeCurrencies->where('code', $currencyCode)->first();

        if (!$currencyData) {
            abort(400, 'Invalid currency');
        }

        // Store language, currency code, symbol, and exchange rate in Session
        Session::put('locale', $lang);
        Session::put('currency', $currencyData->code);
        Session::put('currency_symbol', $currencyData->symbol);
        Session::put('exchange_rate', $currencyData->exchange_rate);

        // Apply Locale immediately for the redirect response
        App::setLocale($lang);

        return redirect()->back()->with('success', 'Language and currency updated successfully');
    }

    /**
     * Change only currency (keep current language)
     */
    public function currencyChange(Request $request): RedirectResponse
    {
        $currencyCode = $request->currency;

        // Validate Currency
        $activeCurrencies = $this->currencyService->getActiveData();
        $currencyData = $activeCurrencies->where('code', $currencyCode)->first();

        if (!$currencyData) {
            abort(400, 'Invalid currency');
        }

        // Store currency information in Session
        Session::put('currency', $currencyData->code);
        Session::put('currency_symbol', $currencyData->symbol);
        Session::put('exchange_rate', $currencyData->exchange_rate);

        return redirect()->back()->with('success', 'Currency updated successfully');
    }

    /**
     * Change only language (keep current currency)
     */
    public function languageChange(Request $request): RedirectResponse
    {
        $lang = $request->lang;

        // Validate Language
        $activeLanguages = $this->languageService->getActiveData();
        if (!in_array($lang, $activeLanguages->pluck('locale')->toArray())) {
            abort(400, 'Invalid language');
        }

        // Store language in Session
        Session::put('locale', $lang);

        // Apply Locale immediately
        App::setLocale($lang);

        return redirect()->back()->with('success', 'Language updated successfully');
    }

    /**
     * Get current currency data (for AJAX requests)
     */
    public function getCurrentCurrency()
    {
        return response()->json([
            'code' => currency_code(),
            'symbol' => currency_symbol(),
            'exchange_rate' => Session::get('exchange_rate', 1),
        ]);
    }
}
