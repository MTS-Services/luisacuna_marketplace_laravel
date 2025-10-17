<?php

use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Livewire\Backend\Admin\Components\Dashboard;
use App\Livewire\Backend\Admin\Components\UserManagement\AllUser;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'admin', 'adminVerify'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin-management', 'as' => 'am.'], function () {
        Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('edit');
            Route::get('/trash', 'trash')->name('trash');
        });
    });
});
