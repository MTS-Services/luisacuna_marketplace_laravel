<?php


use App\Http\Controllers\Backend\Admin\GameManagement\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AuditingController;
use App\Http\Controllers\Backend\Admin\Settings\CurrencyController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Http\Controllers\Backend\Admin\GameManagement\GameController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\RoleController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Backend\Admin\BannerManagement\BannerController;
use App\Http\Controllers\Backend\Admin\GameManagement\CategoryController;
use App\Http\Controllers\Backend\Admin\OfferManagement\OfferController;
use App\Http\Controllers\Backend\Admin\RewardManagement\RankController;
use App\Http\Controllers\Backend\Admin\ReviewManagement\PageViewController;
use App\Http\Controllers\Backend\Admin\GameManagement\PlatformController;
use App\Http\Controllers\Backend\Admin\Settings\ApplicationSettingController;
use App\Http\Controllers\Backend\Admin\RewardManagement\AchievementController;
use App\Http\Controllers\Backend\Admin\RewardManagement\AchievementTypeController;

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
        Route::controller(PlatformController::class)->name('platform.')->prefix('platform')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
        Route::controller(TagController::class)->name('tag.')->prefix('tag')->group(function () {
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
            Route::get('/{id}/config', 'config')->name('config');
        });
    });

    // Banner

    route::group(['prefix' => 'banner-management', 'as' => 'bm.'], function () {
        Route::controller(BannerController::class)->name('banner.')->prefix('banner')->group(function () {
            Route::get('/', 'index')->name('index');
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
        Route::controller(AchievementTypeController::class)->name('achievementType.')->prefix('achievementType')->group(function () {
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

            Route::get('all-seller', 'allSeller')->name('all-seller');
            Route::get('seller-trash', 'sellerTrash')->name('seller-trash');
            Route::get('all-buyer', 'allBuyer')->name('all-buyer');
            Route::get('buyer-trash', 'buyerTrash')->name('buyer-trash');
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

        Route::controller(ApplicationSettingController::class)->group(function () {
            Route::get('/general', 'generalSettings')->name('general-settings');
            Route::get('/database', 'databaseSettings')->name('database-settings');
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
