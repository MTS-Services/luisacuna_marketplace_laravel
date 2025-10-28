<?php

use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Buttons;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\GiftCardController;
use App\Http\Controllers\Frontend\UserAccountController;
use App\Http\Controllers\Frontend\UserProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
Route::get('profile', [UserProfileController::class, 'profile'])->name('profile');
Route::get('account', [UserAccountController::class, 'account'])->name('account');
// GiftCard
Route::get('gift-card', [GiftCardController::class, 'index'])->name('gift-card');