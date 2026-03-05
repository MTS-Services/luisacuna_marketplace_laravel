<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;

class BanHistory extends Component
{
    public User $user;

    public function render()
    {
        $bans = $this->user->userBans()
            ->latest('id')
            ->get();

        return view('livewire.backend.admin.user-management.user.profile.ban-history', [
            'bans' => $bans,
        ]);
    }
}

