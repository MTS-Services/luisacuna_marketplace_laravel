<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');