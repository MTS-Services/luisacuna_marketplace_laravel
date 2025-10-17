<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class ShopInfo extends Component
{

    public $user;
    public $activeTab = 'shop_info';
    #[On('loadProfileInfo')]
    public function profile_info($id)
    {
        $this->user = User::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.profile.shop-info', [
            'user' => $this->user,
            'activeTab' => $this->activeTab,
        ]);
    }
}
