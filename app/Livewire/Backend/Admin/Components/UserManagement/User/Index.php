<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Enums\UserStatus;
use App\Services\User\UserService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Index extends Component
{

    use WithDataTable, WithNotification;

    // public $statusFilter = '';
    // public $showDeleteModal = false;
    // public $deleteAdminId = null;
    // public $bulkAction = ''; 

    // protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected UserService $userService;

    public function boot(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function render()
    {
        $users = $this->userService->getUsersPaginated(
            perPage: $this->perPage,
        );

        $columns = [
            ['key' => 'id', 'label' => 'ID', 'width' => '5%'],
            ['key' => 'avatar', 'label' => 'Avatar', 'format' => function ($user) {
                return $user->avatar_url ? '<img src="' . $user->avatar_url . '" alt="' . $user->name . '" class="avatar avatar-md rounded-full w-10">' : '';
            }],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'created_at', 'label' => 'Created'],
            ['key' => 'created_by', 'label' => 'Created By', 'format' => function ($user) {
                return $user->createdBy ? $user->createdBy->name : 'System';
            }],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openDeleteModal'],
        ];

        $statuses = UserStatus::options();
        return view('livewire.backend.admin.components.user-management.user.index', compact(
            'users',
            'columns',
            'actions',
            'statuses'
        ));
    }
}
