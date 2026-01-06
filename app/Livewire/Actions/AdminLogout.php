<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminLogout
{
    public function __invoke()
    {
        Log::info('Admin logged out');
        Auth::guard('admin')->user()->logoutCurrentDevice();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
