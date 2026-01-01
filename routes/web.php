<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MultiLangController;
use App\Http\Controllers\PaymentController;
use App\Livewire\FileUploader;
use App\Livewire\ImageUploader;
use App\Livewire\Test\Checkout;
use App\Livewire\Test\Items;
use App\Livewire\ToastDemo;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::post('language', [MultiLangController::class, 'langChange'])->name('lang.change');



// Webhook routes (no auth)
Route::post('/webhooks/stripe', [PaymentController::class, 'stripeWebhook'])->name('webhooks.stripe');
Route::post('/webhooks/coinbase', [PaymentController::class, 'coinbaseWebhook'])->name('webhooks.coinbase');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/test', Items::class)->name('test');

    Route::get('/game-checkout/{slug}/{token}', [CheckoutController::class, 'checkout'])->name('game.checkout');
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
    ->name('webhook.stripe')
    ->withoutMiddleware([VerifyCsrfToken::class]);
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


use App\Notifications\UserNotification;
use App\Notifications\AdminNotification;

// Test user notification
// Route::get('/test-user-notification', function () {
//     $user = user();

//     if (!$user) {
//         return 'Please login first';
//     }

//     $user->notify(new UserNotification(
//         title: 'Test Notification',
//         message: 'This is a test notification from Pusher!',
//         actionUrl: route('profile'),
//         type: 'info'
//     ));

//     return 'User notification sent! Check your notification bell.';
// });

// // Test admin notification
// Route::get('/test-admin-notification', function () {
//     $admin = admin();

//     if (!$admin) {
//         return 'Please login as admin first';
//     }

//     $admin->notify(new AdminNotification(
//         title: 'Test Admin Notification',
//         message: 'This is a test notification for admin!',
//         actionUrl: route('admin.dashboard'),
//         type: 'success'
//     ));

//     return 'Admin notification sent! Check your notification bell.';
// });

Route::get('/send', function () {
    return view('send');
});
Route::post('/send-notification', [App\Http\Controllers\TestController::class, 'sendNotification'])->name('send-notification');

Route::get('/cloudinary', ImageUploader::class)->name('image-uploader');
Route::get('/file-uploader', FileUploader::class)->name('file-uploader');

Route::get('/test-cloudinary', function () {
    dd([
        'cloud_name' => config('cloudinary.cloud_name'),
        'api_key' => config('cloudinary.api_key'),
        'api_secret' => config('cloudinary.api_secret'),
    ]);
});



Route::get('/toastDemo', ToastDemo::class)->name('toastDemo');
require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
require __DIR__ . '/fortify-admin.php';
