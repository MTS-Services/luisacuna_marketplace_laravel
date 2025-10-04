<?php

use App\Livewire\Backend\Admin\Components\Dashboard;
use App\Livewire\Backend\Admin\Components\UserManagement\AllUser;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');
});
