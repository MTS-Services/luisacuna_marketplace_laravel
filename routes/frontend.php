<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BoostingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\ItemsController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'boosting', 'as' => 'boost.'], function () {
    Route::get('/', [BoostingController::class, 'index'])->name('index');
    Route::get('/seller-list/{id?}', [BoostingController::class, 'sellerList'])->name('seller-list');
    Route::get('/buy-now/{id?}', [BoostingController::class, 'buyNow'])->name('buy-now');
});
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
Route::get('profile', [UserProfileController::class, 'profile'])->name('profile');
Route::get('account', [UserAccountController::class, 'account'])->name('account');
// GiftCard
Route::get('gift-card', [GiftCardController::class, 'index'])->name('gift-card');
// Items
Route::get('/items', [ItemsController::class, 'items'])->name('items');


// 

Route::group(['prefix' => 'orders', 'as' => 'om.'], function () {
   Route::get('/', [OrderController::class, 'index'])->name('index');
   Route::get('/cancel', [OrderController::class, 'cancel'])->name('cancel');
   Route::get('/chat-help', [OrderController::class, 'chatHelp'])->name('chat-help');
   Route::get('/complete', [OrderController::class, 'complete'])->name('complete');
}); 