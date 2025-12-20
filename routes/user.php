<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SellerVerificationController;
use App\Http\Controllers\Backend\User\OfferManagement\OfferController;
use App\Http\Controllers\Backend\User\OrderManagement\OrderController;
use App\Http\Controllers\Backend\User\OfferManagement\UserOfferController;
use App\Http\Controllers\Backend\User\OrderManagement\OngoingOrderController;

// , 'userVerify'
Route::middleware(['auth', 'userVerify'])->prefix('dashboard')->name('user.')->group(function () {

    Route::group(['prefix' => 'orders'], function () {
        // Route::get('/purchased-orders', function () {
        //     return view('backend.user.pages.orders.purchased-orders');
        // })->name('purchased-orders');
        // Route::get('/sold-orders', function () {
        //     return view('backend.user.pages.orders.sold-orders');
        // })->name('sold-orders');


        Route::controller(OrderController::class)->name('order.')->prefix('order')->group(function () {
            Route::get('/purchased-orders', 'purchasedOrders')->name('purchased-orders');
            Route::get('/sold-orders', 'soldOrders')->name('sold-orders');
        });

        Route::get('/order-details', function () {
            return view('backend.user.pages.orders.order-details');
        })->name('order-details');
        Route::get('/order-description', function () {
            return view('backend.user.pages.orders.order-description');
        })->name('order-description');

        Route::controller(OngoingOrderController::class)->name('OngoingOrder.')->prefix('OngoingOrder')->group(function () {
            Route::get('/details', 'details')->name('details');
            Route::get('/description', 'description')->name('description');
        });


    });

    Route::group(['prefix' => 'offers'], function () {

        Route::controller(UserOfferController::class)->name('user-offer.')->prefix('offer')->group(function () {
            Route::get('/{categorySlug}', 'category')->name('category');
        });


        // Route::get('/currency', function () {
        //     return view('backend.user.pages.offers.currency');
        // })->name('currency');
        // Route::get('/accounts', function () {
        //     return view('backend.user.pages.offers.accounts');
        // })->name('accounts');
        // Route::get('/top-ups', function () {
        //     return view('backend.user.pages.offers.top-ups');
        // })->name('top-ups');
        // Route::get('/items', function () {
        //     return view('backend.user.pages.offers.items');
        // })->name('items');
        // Route::get('/gift-cards', function () {
        //     return view('backend.user.pages.offers.gift-cards');
        // })->name('gift-cards');
        Route::get('offers/', [OfferController::class, 'index'])->name('offers');
    });


    Route::group(['prefix' => 'boosting'], function () {
        Route::get('/my-requests', function () {
            return view('backend.user.pages.boosting.my-requests');
        })->name('my-requests');
        Route::get('/received-requests', function () {
            return view('backend.user.pages.boosting.received-requests');
        })->name('received-requests');
        Route::get('/subscriptions', function () {
            return view('backend.user.pages.boosting.subscriptions');
        })->name('subscriptions');
    });

    Route::group(['prefix' => 'seller'], function () {

        Route::get('verification/{step?}',[SellerVerificationController::class,'index'])->name('seller.verification');
        // Route::get('/verification', function () {
        //     return view('backend.user.pages.seller.seller-verification');
        // })->name('seller.verification');
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
        return view('backend.user.pages.settings.account-seuserttings');
    })->name('account-settings');

    Route::get('/profile', function () {
        return view('backend.user.pages.profile');
    })->name('profile');

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/card', [PaymentController::class, 'processCard'])->name('payment.card');
    Route::post('/payment/digital-wallet', [PaymentController::class, 'processDigitalWallet'])->name('payment.digital-wallet');
    Route::post('/payment/crypto', [PaymentController::class, 'processCrypto'])->name('payment.crypto');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});
