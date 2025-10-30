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
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'boosting', 'as' => 'boost.'], function () {
    Route::get('/', [BoostingController::class, 'index'])->name('index');
    Route::get('/seller-list/{id?}', [BoostingController::class, 'sellerList'])->name('seller-list');
    Route::get('/buy-now/{id?}', [BoostingController::class, 'buyNow'])->name('buy-now');
    Route::get('/checkout/{id?}', [BoostingController::class, 'checkout'])->name('checkout');

});
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
Route::get('profile', [UserProfileController::class, 'profile'])->name('profile');
Route::get('account', [UserAccountController::class, 'account'])->name('account');
// GiftCard
Route::group(['prefix' => 'gift-card', 'as' => 'gift-card.'], function () {
    Route::get('/', [GiftCardController::class, 'index'])->name('index');
    Route::get('seller-list/{id?}', [GiftCardController::class, 'sellerList'])->name('seller-list');
});
// Items
Route::get('/items', [ItemsController::class, 'items'])->name('items');


// 

Route::group(['prefix' => 'orders', 'as' => 'om.'], function () {
   Route::get('/', [OrderController::class, 'index'])->name('index');
   Route::get('/cancel', [OrderController::class, 'cancel'])->name('cancel');
   Route::get('/chat-help', [OrderController::class, 'chatHelp'])->name('chat-help');
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
