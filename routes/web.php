<?php

use App\Http\Controllers\MultiLangController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Test\Checkout;
use App\Livewire\Test\Items;
use Illuminate\Support\Facades\Route;
use App\Livewire\User\UserCreate;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserList;
use Illuminate\Support\Facades\Redis;

Route::post('language', [MultiLangController::class, 'langChange'])->name('lang.change');



// Webhook routes (no auth)
Route::post('/webhooks/stripe', [PaymentController::class, 'stripeWebhook'])->name('webhooks.stripe');
Route::post('/webhooks/coinbase', [PaymentController::class, 'coinbaseWebhook'])->name('webhooks.coinbase');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/test', Items::class)->name('test');
    Route::get('/checkout/{slug}/{token}', Checkout::class)->name('checkout');
    // Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');

    // Payment routes
    // Initialize payment (create payment intent)
    Route::post('/payment/initialize', [PaymentController::class, 'initializePayment'])
        ->name('payment.initialize');

    // Confirm payment (after frontend processing)
    Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment'])
        ->name('payment.confirm');

    // Success and failure pages
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])
        ->name('payment.success');

    Route::get('/payment/failed', [PaymentController::class, 'paymentFailed'])
        ->name('payment.failed');

    // Get gateway configuration
    Route::get('/payment/gateway/{slug}', [PaymentController::class, 'getGatewayConfig'])
        ->name('payment.gateway.config');
});

// Webhook routes (no auth/CSRF middleware)
Route::post('/webhook/stripe', [PaymentController::class, 'stripeWebhook'])
    ->name('webhook.stripe');
// ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);



Route::get('/test-deepl', function () {
    $translator = app(App\Services\DeepLTranslationService::class);

    try {
        $result = $translator->translate('Hello, how are you?', 'BN');

        return response()->json([
            'success' => true,
            'original' => 'Hello, how are you?',
            'translated' => $result,
            'usage' => $translator->getUsage()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});


Route::get('/test-redis-connection', function () {
    try {
        Redis::ping();
        return response()->json([
            'status' => 'success',
            'message' => 'Redis connection successful!',
            'redis_host' => config('database.redis.default.host'),
            'redis_port' => config('database.redis.default.port'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Redis connection failed: ' . $e->getMessage(),
        ], 500);
    }
});


require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
require __DIR__ . '/fortify-admin.php';
