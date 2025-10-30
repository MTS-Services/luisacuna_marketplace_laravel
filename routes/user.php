<?php

use App\Livewire\Backend\User\Components\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'userVerify'])->prefix('user')->name('user.')->group(function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/purchased-orders', function () {
            return view('backend.user.pages.purchased-orders');
        })->name('purchased-orders');
        Route::get('/sold-orders', function () {
            return view('backend.user.pages.orders.sold-orders');
        })->name('sold-orders');
    });

    Route::group(['prefix' => 'orders'], function () {});

    Route::get('/profile', function () {
        return view('backend.user.pages.profile');
    })->name('profile');
});
