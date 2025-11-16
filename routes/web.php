<?php

use App\Http\Controllers\MultiLangController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Livewire\User\UserCreate;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserList;

Route::middleware(['auth'])->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', UserList::class)->name('index');
        Route::get('/create', UserCreate::class)->name('create');
        Route::get('/{user}/edit', UserEdit::class)->name('edit');
    });
});

Route::post('language', [MultiLangController::class, 'langChange'])->name('lang.change');

// Webhook routes (no auth)
Route::post('/webhooks/stripe', [PaymentController::class, 'stripeWebhook'])->name('webhooks.stripe');
Route::post('/webhooks/coinbase', [PaymentController::class, 'coinbaseWebhook'])->name('webhooks.coinbase');

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
require __DIR__ . '/fortify-admin.php';
