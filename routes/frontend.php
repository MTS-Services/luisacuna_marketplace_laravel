<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ItemsController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\TopUpController;
use App\Http\Controllers\Frontend\AccountsController;
use App\Http\Controllers\Frontend\BoostingController;
use App\Http\Controllers\Frontend\CoachingController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\GameController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FavoriteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sellings', [HomeController::class, 'selling'])->name('selling');
Route::get('/select-game', [HomeController::class, 'selectGame'])->name('select-game');
Route::get('/sell-currency', [HomeController::class, 'sellCurrency'])->name('sell-currency');




Route::group(['prefix' => 'boosting', 'as' => 'boost.'], function () {
    Route::get('/', [BoostingController::class, 'index'])->name('index');
    Route::get('/seller-list/{id?}', [BoostingController::class, 'sellerList'])->name('seller-list');
    Route::get('/buy-now/{id?}', [BoostingController::class, 'buyNow'])->name('buy-now');
    Route::get('/checkout/{id?}', [BoostingController::class, 'checkout'])->name('checkout');
// Route::group(['prefix' => 'boosting', 'as' => 'boost.'], function () {
//     Route::get('/', [BoostingController::class, 'index'])->name('index');
//     Route::get('/seller-list/{id?}', [BoostingController::class, 'sellerList'])->name('seller-list');
//     Route::get('/buy-now/{id?}', [BoostingController::class, 'buyNow'])->name('buy-now');
//     Route::get('/checkout/{id?}', [BoostingController::class, 'checkout'])->name('checkout');

 });

Route::get('profile', [UserProfileController::class, 'profile'])->name('profile');

// GiftCard
// Route::group(['prefix' => 'gift-card', 'as' => 'gift-card.'], function () {
//     Route::get('/', [GiftCardController::class, 'index'])->name('index');
//     Route::get('seller-list/{id?}', [GiftCardController::class, 'sellerList'])->name('seller-list');
//     Route::get('check-out/{id?}', [GiftCardController::class, 'checkOut'])->name('check-out');
// });
// Items
Route::get('/items', [ItemsController::class, 'items'])->name('items');


//

Route::group(['prefix' => 'orders', 'as' => 'om.'], function () {
   Route::get('/', [OrderController::class, 'index'])->name('index');
   Route::get('/cancel', [OrderController::class, 'cancel'])->name('cancel');
   Route::get('/chat-help', [OrderController::class, 'chatHelp'])->name('chat-help');
   Route::get('/chat-help-two', [OrderController::class, 'chatHelpTwo'])->name('chat-help-two');
   Route::get('/chat-help-three', [OrderController::class, 'chatHelpThree'])->name('chat-help-three');
   Route::get('/complete', [OrderController::class, 'complete'])->name('complete');
});
// account
Route::get('/accounts', [AccountsController::class, 'accounts'])->name('accounts');
// top up
Route::get('/top-up', [TopUpController::class, 'topUp'])->name('top-up');
// gift card
// Route::get('/gift-card', [GiftCardController::class, 'giftCard'])->name('gift-card');
// Coaching
Route::get('/coaching', [CoachingController::class, 'coaching'])->name('coaching');
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');

// email-temp
// Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email_templates.index');
// Route::get('/email-templates/{id}', [EmailTemplateController::class, 'show'])->name('email_templates.show');
// / Email Templates Routes
Route::prefix('email-templates')->group(function () {
    Route::get('/', [EmailTemplateController::class, 'index'])->name('email_templates.index');
    Route::get('/create', [EmailTemplateController::class, 'create'])->name('email_templates.create');
    Route::post('/store', [EmailTemplateController::class, 'store'])->name('email_templates.store');
    Route::get('/edit/{id}', [EmailTemplateController::class, 'edit'])->name('email_templates.edit');
    Route::put('/update/{id}', [EmailTemplateController::class, 'update'])->name('email_templates.update');
    Route::delete('/delete/{id}', [EmailTemplateController::class, 'destroy'])->name('email_templates.delete');

    Route::get('/trash', [EmailTemplateController::class, 'trash'])->name('email_templates.trash');
    Route::get('/{id}', [EmailTemplateController::class, 'show'])->name('email_templates.show');
});



Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite_favorite.index');
Route::get('/favorite/{id}', [FavoriteController::class, 'show'])->name('favorite_favorite.show');



Route::get('boosting', [BoostingController::class, 'index'])->name('boosting');
Route::get('account', [UserAccountController::class, 'index'])->name('account');
Route::get('/items', [ItemsController::class, 'index'])->name('items');
Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts');
Route::get('/top-up', [TopUpController::class, 'index'])->name('top-up');
Route::get('/gift-card', [GiftCardController::class, 'index'])->name('gift-card');
Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching');

Route::get('/game/{gameSlug}/{categorySlug}', [GameController::class, 'index'])->name('game.index');
Route::get('/game-buy/{gameSlug}/{categorySlug}/{sellerSlug}', [GameController::class, 'buy'])->name('game.buy');
Route::get('/game-checkout/{orderId}', [GameController::class, 'checkout'])->name('game.checkout');
