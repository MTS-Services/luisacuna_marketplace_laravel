<?php

namespace App\Livewire\Backend\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserHeartbeat extends Component
{
    public function ping()
    {
        if (Auth::guard('web')->check()) {
            user()->update(['last_seen_at' => now()]);
        }
    }
    public function render()
    {
        return view('livewire.backend.user.user-heartbeat');
    }
}
