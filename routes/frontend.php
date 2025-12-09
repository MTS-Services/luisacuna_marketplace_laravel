<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ItemsController;
use App\Http\Controllers\Frontend\TopUpController;
use App\Http\Controllers\Frontend\AccountsController;
use App\Http\Controllers\Frontend\BoostingController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\CoachingController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\GameController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
Route::get('/boosting', [BoostingController::class, 'index'])->name('boosting');
Route::get('/account', [UserAccountController::class, 'index'])->name('account');
Route::get('/items', [ItemsController::class, 'index'])->name('items');
Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts');
Route::get('/top-up', [TopUpController::class, 'index'])->name('top-up');
Route::get('/gift-card', [GiftCardController::class, 'index'])->name('gift-card');
Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching');

Route::get('/game/{gameSlug}/{categorySlug}', [GameController::class, 'index'])->name('game.index');
Route::get('/game-buy/{gameSlug}/{categorySlug}/{productId}', [GameController::class, 'buy'])->name('game.buy');


Route::controller(FrontendController::class)->group(function () {
    Route::get('/how-to-buy', 'howToBuy')->name('how-to-buy');
    Route::get('/buyer-protection', 'buyerProtection')->name('buyer-protection');
    Route::get('/how-to-sell', 'howToSell')->name('how-to-sell');
    Route::get('/seller-protection', 'sellerProtection')->name('seller-protection');
    Route::get('/faq', 'faq')->name('faq');
    // Route::get('/faq', 'faq')->name('faq');
    Route::get('/contact-us', 'contactUs')->name('contact-us');
    Route::get('/terms-and-conditions', 'termsAndConditions')->name('terms-and-conditions');
    Route::get('/refund-policy', 'refunPolicy')->name('refund-policy');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
});
Route::get('/users/{username}', [UserProfileController::class, 'index'])->name('profile');
// Route::controller(UserProfileController::class)->name('profile.')->prefix('profile')->group(function () {
//     Route::get('/{username}', 'index')->name('index');
//     // Route::get('/shop', 'shop')->name('shop');
//     // Route::get('/edit/{id}', 'edit')->name('edit');
//     // Route::get('/view/{id}', 'view')->name('view');
//     // Route::get('/trash', 'trash')->name('trash');
// });
