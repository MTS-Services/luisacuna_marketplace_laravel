<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SellerVerificationController;
use App\Http\Controllers\Backend\User\OfferManagement\OfferController;
use App\Http\Controllers\Backend\User\OrderManagement\OrderController;
use App\Http\Controllers\Backend\User\OfferManagement\UserOfferController;
use App\Http\Controllers\Backend\User\OfferManagement\BulkUploadController;
use App\Http\Controllers\Backend\User\WalletManagement\WalletController;
use App\Livewire\Backend\User\Payments\Checkout;

// , 'userVerify'
Route::middleware(['auth', 'userVerify'])->prefix('dashboard')->name('user.')->group(function () {


    Route::controller(OrderController::class)->name('order.')->prefix('orders')->group(function () {
        Route::get('/purchased-orders', 'purchasedOrders')->name('purchased-orders');
        Route::get('/sold-orders', 'soldOrders')->name('sold-orders');
        Route::get('/cancel/{orderId}', 'cancel')->name('cancel');
        Route::get('/complete/{orderId}', 'complete')->name('complete');
        Route::get('/details/{orderId}', 'detail')->name('detail');
    });


    Route::group(['prefix' => 'offers'], function () {

        Route::controller(UserOfferController::class)->name('user-offer.')->prefix('offer')->group(function () {
            Route::get('/{categorySlug}', 'category')->name('category');
        });
        Route::controller(BulkUploadController::class)->name('bulk-upload.')->prefix('bulk-upload')->group(function () {
            Route::get('category', 'category')->name('category');
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
        Route::get('create/', [OfferController::class, 'create'])->name('offers')->middleware('seller');
        Route::get('edit/{encrypted_id}', [OfferController::class, 'edit'])->name('offer.edit')->middleware('seller');
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

        Route::get('verification/{step?}', [SellerVerificationController::class, 'index'])->name('seller.verification');
    });



    Route::get('/loyalty', function () {
        return view('backend.user.pages.loyalty.loyalty');
    })->name('loyalty');

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

    // Route::get('/profile', function () {
    //     return view('backend.user.pages.profile');
    // })->name('profile');

    Route::get('/checkout/{slug}/{token}', Checkout::class)->name('checkout');

    Route::controller(PaymentController::class)
        ->name('payment.')
        ->prefix('payment')
        ->group(function () {
            Route::get('/success', 'paymentSuccess')->name('success');
            Route::get('/topup-success', 'paymentSuccess')->name('topup.success');
            Route::get('/failed', 'paymentFailed')->name('failed');
            Route::get('/gateway/{slug}', 'getGatewayConfig')->name('gateway.config');
        });

    Route::controller(WalletController::class)->name('wallet.')->prefix('wallet')->group(function () {
        Route::get('/', 'wallet')->name('index');
        Route::get('/withdrawal-methods', 'withdrawalMethod')->name('withdrawal-methods');
        Route::get('/withdrawal-form/{id}', 'withdrawalForm')->name('withdrawal-form');
        Route::get('/withdrawal-form-update/{account}','withdrawalFormUpdate')->name('withdrawal-form-update');
    });
});
