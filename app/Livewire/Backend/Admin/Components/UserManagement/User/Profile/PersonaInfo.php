<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class PersonaInfo extends Component
{
    public $user;
    public $activeTab = 'personal_info';

    protected $listeners = ['loadProfileInfo' => 'profile_info'];
    #[On('loadProfileInfo')]
    public function profile_info($id)
    {
        $this->user = User::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.profile.persona-info', [
            'user' => $this->user,
            'activeTab' => $this->activeTab,
        ]);
    }
}
