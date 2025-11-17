<?php


use App\Http\Controllers\Backend\Admin\AdminManagement\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AuditingController;
use App\Http\Controllers\Backend\Admin\Settings\CurrencyController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Http\Controllers\Backend\Admin\GameManagement\GameController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Backend\Admin\GameManagement\CategoryController;
use App\Http\Controllers\Backend\Admin\GameManagement\GamePlatformController;
use App\Http\Controllers\Backend\Admin\GameManagement\GameServerController;
use App\Http\Controllers\Backend\Admin\OfferManagement\OfferController;
use App\Http\Controllers\Backend\admin\ProductManagament\ProductController;
use App\Http\Controllers\Backend\admin\ProductManagament\ProductTypeController;
use App\Http\Controllers\Backend\Admin\ReviewManagement\PageViewController;
use App\Http\Controllers\Backend\Admin\RewardManagement\AchievementController;
use App\Http\Controllers\Backend\Admin\RewardManagement\RankController;
use App\Http\Controllers\Backend\Admin\Settings\ApplicationSettingController;
use App\Http\Controllers\Backend\Admin\Settings\GeneralSettingsController;

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

        Route::controller(RoleController::class)->name('role.')->prefix('role')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
        Route::controller(PermissionController::class)->name('permission.')->prefix('permission')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
        });
    });


    // Game
    Route::group(['prefix' => 'game-management', 'as' => 'gm.'], function () {
      
        Route::controller(CategoryController::class)->name('category.')->prefix('category')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
        
        Route::controller(GameServerController::class)->name('server.')->prefix('game-server')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
        });
        Route::controller(GamePlatformController::class)->name('platform.')->prefix('game-platform')->group(function () {
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

    // Rank
    Route::group(['prefix' => 'reward-management', 'as' => 'rm.'], function () {
        Route::controller(RankController::class)->name('rank.')->prefix('rank')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
        Route::controller(AchievementController::class)->name('achievement.')->prefix('achievement')->group(function () {

            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
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

        Route::controller(GeneralSettingsController::class)->prefix('general-settings')->group(function () {
            Route::get('/', 'index')->name('general-settings');
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

    Route::group(['offer-management', 'as' => 'om.'], function () {
        Route::controller(OfferController::class)->name('offer.')->prefix('offer-management')->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});
