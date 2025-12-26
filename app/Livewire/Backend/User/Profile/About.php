<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class About extends Component
{
    use WithNotification;
    public $user;

    public $description ; 

    public $editMode = false; 

    protected UserService $userService;
    public function boot(UserService $userService){

        $this->userService = $userService;

    }
    public function mount(User $user)
    {
        $this->user = $user;
        $this->description = $user->description;
    }
    public function render()
    {
        return view('livewire.backend.user.profile.about');
    }

    public function switchToEditMode(){

        $this->editMode = !$this->editMode;
    }

    public function save(){
        $this->editMode = !$this->editMode;

        $this->userService->updateData($this->user->id , [
            'description' => $this->description,
        ]);
        $this->toastInfo('Profile updated successfully');
    }
}
