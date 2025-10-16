<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public $selectedUser;
    public $showUserModal = false;
    


    public $userId;
    public $user;

    protected $listeners = ['openUserModal' => 'openDetailsModal'];

    public function openDetailsModal($id)
    {
        
        $this->user = User::findOrFail($id);
        $this->showUserModal = true;
        
    }
    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
    }
    public function render()
    {

        return view('livewire.backend.admin.components.user-management.user.view', [
          'user' => $this->user,

        ]);
    }
}
