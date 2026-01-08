<?php

use App\Http\Controllers\MultiLangController;
use App\Http\Controllers\PaymentController;
use App\Livewire\DeviceManagement;
use App\Livewire\FileManager;
use App\Livewire\SendDeviceNotification;
use App\Livewire\ToastDemo;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::post('language', [MultiLangController::class, 'langChange'])->name('lang.change');

// Webhook routes (no auth)
Route::post('/webhook/stripe', [PaymentController::class, 'stripeWebhook'])
    ->name('webhook.stripe')
    ->withoutMiddleware([VerifyCsrfToken::class]);



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

Route::get('/send', function () {
    return view('send');
});

Route::get('/test-cloudinary', function () {
    try {
        $config = config('filesystems.disks.cloudinary');
        dd([
            'config' => $config,
            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
            'can_connect' => true,
        ]);
    } catch (\Exception $e) {
        dd([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
});

Route::get('/file-manager', FileManager::class)->name('file-manager');

Route::get('/fcm', function () {
    return view('generate-fcm');
});
Route::get('/send-fcm', SendDeviceNotification::class)->name('send-fcm');
Route::get('/device-manage', DeviceManagement::class)->name('device-manage');

Route::get('/toastDemo', ToastDemo::class)->name('toastDemo');
require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
require __DIR__ . '/fortify-admin.php';
