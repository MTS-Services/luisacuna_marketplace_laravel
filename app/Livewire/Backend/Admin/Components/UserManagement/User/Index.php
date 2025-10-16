<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use Livewire\Component;
use App\Enums\AdminStatus;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;


    protected UserService $userService;
    //  public $showUserModal = false;
    // public $user;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function render()
    {
        $users = $this->userService->getUsersPaginated(
            perPage: $this->perPage,
            // filters: $this->getFilters()
        );
        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true
            ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true
            ],
            [
                'key' => 'phone',
                'label' => 'Phone',
                'sortable' => true
            ],
            [
                'key' => 'address',
                'label' => 'Address',
                'sortable' => true
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($admin) {
                    $colors = [
                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                    ];
                    $color = $colors[$admin->status->value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
                        ucfirst($admin->status->value) .
                        '</span>';
                }
            ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.um.user.view'
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.um.user.edit'
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete'
            ],
        ];
        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],
        ];
        return view('livewire.backend.admin.components.user-management.user.index', [
            'users' => $users,
            'columns' => $columns,
            'statuses' => AdminStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions,

        ]);
    }
}
