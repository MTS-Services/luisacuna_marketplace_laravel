<?php

use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin-management', 'as' => 'am.'], function () {
        Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'show')->name('view');
            Route::get('/trash', 'trash')->name('trash');
            
        });
    });
});
