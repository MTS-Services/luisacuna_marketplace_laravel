<?php

use App\Livewire\Backend\User\Components\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'userVerify'])->prefix('user')->name('user.')->group(function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/purchased-orders', function () {
            return view('backend.user.pages.orders.purchased-orders');
        })->name('purchased-orders');
        Route::get('/sold-orders', function () {
            return view('backend.user.pages.orders.sold-orders');
        })->name('sold-orders');
    });

    Route::group(['prefix' => 'offers'], function () {
        Route::get('/currency', function () {
            return view('backend.user.pages.offers.currency');
        })->name('currency');
        Route::get('/accounts', function () {
            return view('backend.user.pages.offers.accounts');
        })->name('accounts');
        Route::get('/top-ups', function () {
            return view('backend.user.pages.offers.top-ups');
        })->name('top-ups');
        Route::get('/items', function () {
            return view('backend.user.pages.offers.items');
        })->name('items');
        Route::get('/gift-cards', function () {
            return view('backend.user.pages.offers.gift-cards');
        })->name('gift-cards');
    });

    Route::group(['prefix' => 'boosting'], function () {
        Route::get('/my-requests', function () {
            return view('backend.user.pages.boosting.my-requests');
        })->name('my-requests');
        Route::get('/received-requests', function () {
            return view('backend.user.pages.boosting.received-requests');
        })->name('received-requests');
    });
    Route::group(['prefix' => 'seller'], function () {
        Route::get('/verification', function () {
            return view('backend.user.pages.seller.seller-verification');
        })->name('seller.verification');
    });


    Route::get('/loyalty', function () {
        return view('backend.user.pages.loyalty.loyalty');
    })->name('loyalty');

    Route::get('/wallet', function () {
        return view('backend.user.pages.wallet.wallet');
    })->name('wallet');
    Route::get('/messages', function () {
        return view('backend.user.pages.chat.messages');
    })->name('messages');
    Route::get('/notifications', function () {
        return view('backend.user.pages.notifications.notifications');
    })->name('notifications');
    Route::get('/feedback', function () {
        return view('backend.user.pages.feedback.feedback');
    })->name('feedback');
    Route::get('/account-settings', function () {
        return view('backend.user.pages.settings.account-settings');
    })->name('account-settings');

    Route::get('/profile', function () {
        return view('backend.user.pages.profile');
    })->name('profile');
});