<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Buyer;

use Livewire\Component;
use App\Services\UserService;
use App\Enums\UserAccountStatus;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class AllBuyer extends Component
{

    use WithDataTable, WithNotification;


    protected UserService $service;

    public $statusFilter = '';
    public $deleteUserId;
    public $bulkAction = '';
    public $showDeleteModal = false;
    public $showBulkActionModal = false;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getAllBuyersData(
            // perPage: $this->perPage,
            // filters: $this->getFilters()
        );

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
        return view('livewire.backend.admin.user-management.user.buyer.all-buyer', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => UserAccountStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($userId): void
    {
        $this->deleteUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteUserId) {
                return;
            }

            // if ($this->deleteUserId == user()->id) {
            //     $this->error('You cannot delete your own account');
            //     return;
            // }

            $this->service->deleteData($this->deleteUserId);

            $this->showDeleteModal = false;
            $this->deleteUserId = null;

            $this->success('User deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete User: ' . $e->getMessage());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($userId, $status): void
    {
        try {
            $userStatus = UserAccountStatus::from($status);

            match ($userStatus) {
                UserAccountStatus::ACTIVE => $this->service->activateData($userId),
                UserAccountStatus::INACTIVE => $this->service->deactivateData($userId),
                default => null,
            };

            $this->success('User status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Users and an action');
            Log::info('No Users selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'activate' => $this->bulkUpdateStatus(UserAccountStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(UserAccountStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->service->bulkDeleteDatas($this->selectedIds);
        $this->success("{$count} Users deleted successfully");
    }

    protected function bulkUpdateStatus(UserAccountStatus $status): void
    {
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Users updated successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'account_status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getPaginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
