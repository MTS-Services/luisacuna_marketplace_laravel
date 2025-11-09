<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ItemsController;
use App\Http\Controllers\Frontend\TopUpController;
use App\Http\Controllers\Frontend\AccountsController;
use App\Http\Controllers\Frontend\BoostingController;
use App\Http\Controllers\Frontend\CoachingController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\GameController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Livewire\Frontend\Components\Boostings\BoostingSubscribe;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [UserProfileController::class, 'profile'])->name('profile');
Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
Route::get('/boosting', [BoostingController::class, 'index'])->name('boosting');
Route::get('/account', [UserAccountController::class, 'index'])->name('account');
Route::get('/items', [ItemsController::class, 'index'])->name('items');
Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts');
Route::get('/top-up', [TopUpController::class, 'index'])->name('top-up');
Route::get('/gift-card', [GiftCardController::class, 'index'])->name('gift-card');
Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching');

Route::get('/game/{gameSlug}/{categorySlug}', [GameController::class, 'index'])->name('game.index');
Route::get('/game-buy/{gameSlug}/{categorySlug}/{sellerSlug}', [GameController::class, 'buy'])->name('game.buy');
Route::get('/game-checkout/{orderId}', [GameController::class, 'checkout'])->name('game.checkout');
