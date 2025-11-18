<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class MultiLangController extends Controller
{
    public function __construct(protected LanguageService $languageService) {}
    public function langChange(Request $request): RedirectResponse
    {
        $lang = $request->lang;
        $currency = $request->currency;

        if (!in_array($lang, $this->languageService->getActiveData()->pluck('locale')->toArray())) {
            abort(400);
        }

        if (!in_array($currency, ['USD-$', 'EUR-€'])) {
            abort(400);
        }

        Session::put('locale', $lang);
        Session::put('currency', $currency);

        App::setLocale($lang);

        return redirect()->back();
    }
}
