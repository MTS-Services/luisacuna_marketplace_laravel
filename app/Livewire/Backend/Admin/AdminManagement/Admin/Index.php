<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Models\Role;
use App\Services\AdminService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected AdminService $service;

    public function boot(AdminService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('role', 'creater_admin');


        $columns = [

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
                'key' => 'role_id',
                'label' => 'Role',
                'format' => function ($data) {
                    return $data->role?->name;
                },
                'sortable' => true
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater_admin?->name ?? 'System';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.am.admin.view',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.am.admin.edit',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
                'encrypt' => true,
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'suspend', 'label' => 'Suspend'],
            ['value' => 'pending', 'label' => 'Pending'],
        ];

        return view('livewire.backend.admin.admin-management.admin.index', [
            'datas' => $datas,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }

            if (decrypt($this->deleteId) == admin()->id) {
                $this->warning('You cannot delete your own account');
                $this->deleteId = null;
                return;
            }
            $this->service->deleteData(decrypt($this->deleteId));
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($id, $status): void
    {
        try {
            $dataStatus = AdminStatus::from($status);

            match ($dataStatus) {
                AdminStatus::ACTIVE => $this->service->updateStatusData($id, AdminStatus::ACTIVE),
                AdminStatus::INACTIVE => $this->service->updateStatusData($id, AdminStatus::INACTIVE),
                AdminStatus::PENDING => $this->service->updateStatusData($id, AdminStatus::SUSPENDED),
                AdminStatus::SUSPENDED => $this->service->updateStatusData($id, AdminStatus::PENDING),
                default => null,
            };

            $this->success('Data status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select data and an action');
            Log::info('No data selected or no bulk action selected');
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
                'pending' => $this->bulkUpdateStatus(AdminStatus::PENDING),
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

        if (in_array(admin()->id, $this->selectedIds)) {
            $this->warning('You cannot delete your own account');
            $this->selectedIds = [];
            return;
        }

        $count =  $this->service->bulkDeleteData($this->selectedIds);

        $this->success("{$count} Data deleted successfully");
    }

    protected function bulkUpdateStatus(AdminStatus $status): void
    {
        if (in_array(admin()->id, $this->selectedIds)) {
            $this->warning('You cannot change your own account');
            $this->selectedIds = [];
            return;
        }
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Data updated successfully");
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
        $data = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
