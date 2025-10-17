<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public $selectedUser;
    public $showUserModal = false;



    // public $userId;
    public $user;
    // public $activeTab = 'personal_info';

    // protected $listeners = ['openUserModal' => 'openDetailsModal'];

    // user profile tabs
    // public $tabs = [
    //     'personal_info' => 'Personal Info',
    //     'shop_info' => 'Shop Info',
    //     'kyc' => 'KYC',
    //     'security_info' => 'Security Info',
    // ];
    // public function switchTab($tabName)
    // {
    //     if (array_key_exists($tabName, $this->tabs)) {
    //         $this->activeTab = $tabName;
    //     }
    // }


    public function openDetailsModal($id)
    {
        $this->user = User::findOrFail($id);
        $this->showUserModal = true;
        $this->dispatch('loadProfileInfo', id: $id);
    }
    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
    }
    public function render()
    {

        return view('livewire.backend.admin.components.user-management.user.view', [
            'user' => $this->user
        ]);
    }
}
