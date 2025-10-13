<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Trash extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteAdminId = null;
    public $bulkAction = '';

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];
    protected AdminService $adminService;
    public function boot(
        AdminService $adminService
    ) {
        $this->adminService = $adminService;
    }


    public function render()
    {
        $admins = $this->adminService->getAdminsPaginatedOnlyTrashed(
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
            ['key' => 'id', 'label' => 'Restore', 'method' => 'restoreAdmin'],
            ['key' => 'id', 'label' => 'Delete Permanently', 'method' => 'confirmDelete'],
        ];

        return view('livewire.backend.admin.components.admin-management.admin.trash', [
            'admins' => $admins,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
        ]);
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

    public function confirmDelete($id)
    {
        $this->deleteAdminId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {

        $this->adminService->deleteAdmin($this->deleteAdminId, true);
        $this->showDeleteModal = false;
        $this->deleteAdminId = null;
        $this->success('admin deleted successfully');
    }
    public function restoreAdmin($id)
    {
        $this->adminService->restoreAdmin($id);
    }
}
