<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\ProductManagement\TopUpsController;
use App\Http\Controllers\Backend\Admin\AuditingController;
use App\Http\Controllers\Backend\Admin\CmsManagement\CmsController;
use App\Http\Controllers\Backend\Admin\FaqManagement\FaqController;
use App\Http\Controllers\Backend\Admin\Settings\CurrencyController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Http\Controllers\Backend\Admin\GameManagement\TagController;
use App\Http\Controllers\Backend\Admin\GameManagement\GameController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\RoleController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\OfferManagement\OfferController;
use App\Http\Controllers\Backend\Admin\RewardManagement\RankController;
use App\Http\Controllers\Backend\Admin\BannerManagement\BannerController;
use App\Http\Controllers\Backend\Admin\GameManagement\CategoryController;
use App\Http\Controllers\Backend\Admin\GameManagement\PlatformController;
use App\Http\Controllers\Backend\Admin\ProductManagement\AccountController;
use App\Http\Controllers\Backend\Admin\ReviewManagement\PageViewController;
use App\Http\Controllers\Backend\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Backend\Admin\FeeSettingsManagement\FeeSettingsController;
use App\Http\Controllers\Backend\Admin\Settings\ApplicationSettingController;
use App\Http\Controllers\Backend\Admin\RewardManagement\AchievementController;
use App\Http\Controllers\Backend\Admin\RewardManagement\AchievementTypeController;
use App\Http\Controllers\Backend\Admin\GatewayAndIntegration\GatewayAndIntegrationController;
use App\Http\Controllers\Backend\Admin\NotificationManagement\AnnouncementController;
use App\Http\Controllers\Backend\Admin\NotificationManagement\NotificationController;
use App\Http\Controllers\Backend\Admin\ProductManagement\BoostingsController;
use App\Http\Controllers\Backend\Admin\ProductManagement\CurrencyController as ProductCurrencyController;
use App\Http\Controllers\Backend\Admin\ProductManagement\GiftCardsController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ItemsController;

Route::middleware(['admin', 'adminVerify'])->name('admin.')->prefix('admin')->group(function () {
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
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
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

            // Seller Verification
            Route::get('seller-verification', 'sellerVerification')->name('seller-verification');
            Route::get('seller-verification/view/{id}', 'sellerVerificationView')->name('seller-verification.view');

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

    // Faq
    Route::group(['prefix' => 'faq-management', 'as' => 'flm.'], function () {

        Route::controller(FaqController::class)->name('faq.')->prefix('faq')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    // Content management
    Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {
        Route::controller(CmsController::class)->name('')->prefix('')->group(function () {
            Route::get('/terms-condition', 'termsCondition')->name('terms-condition');
            Route::get('/refund-policy', 'refundPolicy')->name('refund-policy');
            Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
        });
    });

    Route::group(['as' => 'gi.'], function () {
        Route::controller(GatewayAndIntegrationController::class)->group(function () {
            Route::group(['prefix' => 'payment-gateway', 'as' => 'pay-g.'], function () {
                Route::get('/', 'paymentIndex')->name('index');
                Route::get('/edit/{id}', 'paymentEdit')->name('edit');
            });
            Route::group(['prefix' => 'withdraw-gateway', 'as' => 'wi-g.'], function () {
                Route::get('/', 'withdrawIndex')->name('index');
                Route::get('/edit/{id}', 'withdrawEdit')->name('edit');
            });
            Route::get('/translation-keys', 'translationKeys')->name('translation-keys');
        });
    });
    Route::group(['prefix' => 'product-management', 'as' => 'pm.'], function () {
        Route::controller(ProductCurrencyController::class)->name('category.')->prefix('category')->group(function () {
            Route::get('/{categorySlug}', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
        });

        // Route::controller(AccountController::class)->name('account.')->prefix('account')->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/create', 'create')->name('create');
        // });
        // Route::controller(TopUpsController::class)->name('top-ups.')->prefix('top-ups')->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/create', 'create')->name('create');
        // });
        // Route::controller(ItemsController::class)->name('items.')->prefix('items')->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/create', 'create')->name('create');
        // });
        // Route::controller(BoostingsController::class)->name('boostings.')->prefix('boostings')->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/create', 'create')->name('create');
        // });
        // Route::controller(GiftCardsController::class)->name('gift-cards.')->prefix('gift-cards')->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/create', 'create')->name('create');
        // });
    });


    Route::controller(FeeSettingsController::class)->name('fee-settings.')->prefix('fee-settings')->group(function () {
        Route::get('/fee-settings', 'feeSettings')->name('fee-settings');
    });

    Route::controller(AnnouncementController::class)->name('announcement.')->prefix('announcement')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });
    Route::controller(NotificationController::class)->name('notification.')->prefix('notification')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });
});
