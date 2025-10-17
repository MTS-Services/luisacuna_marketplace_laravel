<?php

use App\Http\Controllers\Auth\User\VerifyEmailController as UserVerifyEmailController;
use App\Http\Controllers\Auth\Admin\VerifyEmailController as AdminVerifyEmailController;
use App\Livewire\Actions\Logout;

use Illuminate\Support\Facades\Route;

// User Auth Routes
Route::middleware('guest:web')->group(function () {
    Route::get('login', function () {
        return view('frontend.auth.user.login');
    })->name('login');
    Route::get('register', function () {
        return view('frontend.auth.user.register');
    })->name('register');
    Route::get('forgot-password', function () {
        return view('frontend.auth.user.forgot-password');
    })->name('password.request');
    Route::get('reset-password/{token}', function () {
        return view('frontend.auth.user.reset-password');
    })->name('password.reset');
});

Route::middleware('auth:web')->group(function () {
    Route::get('verify-email', function () {
        return view('frontend.auth.user.verify-email');
    })->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', UserVerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

Route::post('logout', Logout::class)
    ->name('logout');

// Admin Auth Routes 
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', function () {
            return view('frontend.auth.admin.login');
        })->name('login');
        Route::get('forgot-password', function () {
            return view('frontend.auth.admin.forgot-password');
        })->name('password.request');
        Route::get('reset-password/{token}', function () {
            return view('frontend.auth.admin.reset-password');
        })->name('password.reset');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('verify-email', function () {
            return view('frontend.auth.admin.verify-email');
        })->name('verification.notice');
            Route::get('verify-otp', function () {
            return view('frontend.auth.admin.verify-otp');
            })->name('verify-otp');
        Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
    });

    Route::post('logout', Logout::class)
        ->name('logout');
});
