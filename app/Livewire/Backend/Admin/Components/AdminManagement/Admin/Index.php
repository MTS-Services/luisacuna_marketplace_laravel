<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteAdminId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected AdminService $adminService;
    public function boot(
        AdminService $adminService
    ) {
        $this->adminService = $adminService;
    }


    public function render()
    {
        $admins = $this->adminService->getAdminsPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [

            ['key' => 'avatar', 'label' => 'Avatar', 'format' => function ($admin) {
                return $admin->avatar_url ? '<img src="' . $admin->avatar_url . '" alt="' . $admin->name . '" class="avatar avatar-md rounded-full w-10">' : '';
            }],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'created_at', 'label' => 'Created'],
            ['key' => 'created_by', 'label' => 'Created By', 'format' => function ($admin) {
                return $admin->createdBy ? $admin->createdBy->name : 'System';
            }],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.am.admin.edit'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];
        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],
        ];

        return view('livewire.backend.admin.components.admin-management.admin.index', [
            'admins' => $admins,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($adminId): void
    {
        $this->deleteAdminId = $adminId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteAdminId) {
                return;
            }
            if ($this->deleteAdminId == admin()->id) {
                $this->error('You cannot delete your own account');
                return;
            }

            $this->adminService->deleteAdmin($this->deleteAdminId);

            $this->showDeleteModal = false;
            $this->deleteAdminId = null;

            $this->success('admin deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete Admin: ' . $e->getMessage());
        }
    }

    // public function forceDelete($adminId): void
    // {
    //     try {
    //         $this->adminService->deleteAdmin($adminId, forceDelete: true);
    //         $this->success('admin permanently deleted');
    //     } catch (\Exception $e) {
    //         $this->error('Failed to delete Admin: ' . $e->getMessage());
    //     }
    // }

    // public function restore($adminId): void
    // {
    //     try {
    //         $this->adminService->restoreAdmin($adminId);
    //         $this->success('admin restored successfully');
    //     } catch (\Exception $e) {
    //         $this->error('Failed to restore Admin: ' . $e->getMessage());
    //     }
    // }

    public function changeStatus($adminId, $status): void
    {
        try {
            $adminStatus = AdminStatus::from($status);

            match ($adminStatus) {
                AdminStatus::ACTIVE => $this->adminService->activateAdmin($adminId),
                AdminStatus::INACTIVE => $this->adminService->deactivateAdmin($adminId),
                AdminStatus::SUSPENDED => $this->adminService->suspendAdmin($adminId),
                default => null,
            };

            $this->success('admin status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Admins and an action');
            Log::info('No Admins selected or no bulk action selected');
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
                'activate' => $this->bulkUpdateStatus(AdminStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(AdminStatus::INACTIVE),
                'suspend' => $this->bulkUpdateStatus(AdminStatus::SUSPENDED),
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
        $count = $this->adminService->bulkDeleteAdmins($this->selectedIds);
        $this->success("{$count} Admins deleted successfully");
    }

    protected function bulkUpdateStatus(AdminStatus $status): void
    {
        $count = $this->adminService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Admins updated successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->adminService->getAdminsPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
