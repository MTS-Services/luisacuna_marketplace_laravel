<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AuditingController;
use App\Http\Controllers\Backend\Admin\Settings\CurrencyController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Http\Controllers\Backend\Admin\GameManagement\GameController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\GameManagement\CategoryController;
use App\Http\Controllers\Backend\admin\ProductManagament\ProductController;
use App\Http\Controllers\Backend\admin\ProductManagament\ProductTypeController;
use App\Http\Controllers\Backend\Admin\ReviewManagement\PageViewController;

Route::middleware(['auth:admin', 'admin', 'adminVerify'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin-management', 'as' => 'am.'], function () {
        Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });


    // Game  Controller
    Route::group(['prefix' => 'game-management', 'as' => 'gm.'], function () {

        Route::controller(CategoryController::class)->name('category.')->prefix('category')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(GameController::class)->name('game.')->prefix('game')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/trash', 'trash')->name('trash');
        });

        
    });
    Route::group(['prefix' => 'user-management', 'as' => 'um.'], function () {
        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
            Route::get('/profile-info/{id}', 'profileInfo')->name('profileInfo');
            Route::get('/shop-info/{id}', 'shopInfo')->name('shopInfo');
            Route::get('/kyc-info/{id}', 'kycInfo')->name('kycInfo');
            Route::get('/statistic/{id}', 'statistic')->name('statistic');
            Route::get('/referral/{id}', 'referral')->name('referral');
        });
    });
    Route::group(['prefix' => 'application-settings', 'as' => 'as.'], function () {
        Route::controller(LanguageController::class)->name('language.')->prefix('language')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(CurrencyController::class)->name('currency.')->prefix('currency')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    Route::group(['prefix' => 'product-management', 'as' => 'pm.'], function () {
        Route::controller(ProductTypeController::class)->name('productType.')->prefix('productType')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash', 'trash')->name('trash');
        });
        Route::controller(ProductController::class)->name('product.')->prefix('product')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    Route::group(['prefix' => 'review-management', 'as' => 'rm.'], function () {
        Route::controller(PageViewController::class)->name('review.')->prefix('review')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash', 'trash')->name('trash');

        });
    });

    Route::group(['prefix' => 'audit-log-management', 'as' => 'alm.'], function () {
        Route::controller(AuditingController::class)->name('audit.')->prefix('audit')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });
});
