<?php

use App\Livewire\Backend\User\Components\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'userVerify'])->name('user.')->group(function () {
    Route::get('/profile', function () {
        return view('backend.user.pages.profile');
    })->name('profile');
});
