<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Pending;

use App\Enums\SellerKycStatus;
use App\Models\SellerKyc;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
class Pending extends Component
{

use WithDataTable, WithNotification;
        public $statusFilter = '';
        public $deleteUserId;
        public $bulkAction = '';
        public $showDeleteModal = false;
        public $showBulkActionModal = false;

    public function render()
    {
        $datas = SellerKyc::all();

        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'avatar',
                'label' => 'Avatar',
                'format' => function ($data) {
                    return $data->avatar_url
                        ? '<img src="' . $data->avatar_url . '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
                        : '<div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">' . strtoupper(substr($data->name, 0, 2)) . '</div>';
                }
            ],

            [
                'key' => 'first_name',
                'label' => 'Name',
                'sortable' => true
            ],

            [
                'key' => 'username',
                'label' => 'User Name',
                'sortable' => true
            ],

            [
                'key' => 'account_status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($user) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium '
                        . $user->account_status_color . '">'
                        . $user->account_status_label .
                        '</span>';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Profile',
                'route' => 'admin.um.user.profileInfo'
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

        return view('livewire.backend.admin.user-management.user.pending.pending', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => SellerKycStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);

    }
}
