<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Models\Role;
use App\Services\AdminService;
use App\Support\SuperAdminGuard;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';

    public $showDeleteModal = false;

    public $selectedId = null;

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
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('deleter_admin', 'role');

        $columns = [
            [
                'key' => 'avatar',
                'label' => 'Avatar',
                'format' => function ($data) {
                    return $data->avatar_url
                        ? '<img src="'.storage_url($data->avatar).'" alt="'.$data->name.'" class="w-10 h-10 rounded-full object-cover shadow-sm">'
                        : '<div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">'.strtoupper(substr($data->name, 0, 2)).'</div>';
                },
            ],
            [
                'key' => 'role_id',
                'label' => 'Role',
                'format' => function ($data) {
                    return $data->role?->name;
                },
                'sortable' => true,
            ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true,
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true,
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft '.$data->status->color().'">'.
                        $data->status->label().
                        '</span>';
                },
            ],
            [
                'key' => 'deleted_at',
                'label' => 'Deleted Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->deleted_at_formatted;
                },
            ],
            [
                'key' => 'deleted_by',
                'label' => 'Deleted By',
                'format' => function ($data) {
                    return $data->deleter_admin?->name ?? 'System';
                },
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore',
                'encrypt' => true,
            ],
            [
                'key' => 'id',
                'label' => 'Permanent Delete',
                'method' => 'confirmDelete',
                'encrypt' => true,
            ],
        ];

        $bulkActions = [
            ['value' => 'forceDelete', 'label' => 'Permanently Delete'],
            ['value' => 'bulkRestore', 'label' => 'Restore'],
        ];

        return view('livewire.backend.admin.admin-management.admin.trash', [
            'admins' => $datas,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        if (! $encryptedId) {
            $this->error('No Data selected');
            $this->resetPage();

            return;
        }
        $this->selectedId = $encryptedId;
        $this->showDeleteModal = true;
    }

    public function forceDelete(): void
    {
        try {
            $adminId = decrypt($this->selectedId);
            $target = Admin::withTrashed()->find($adminId);
            $superAdminRoleId = Role::getSuperAdminRoleId();
            if ($target && $superAdminRoleId !== null && (int) $target->role_id === $superAdminRoleId && ! SuperAdminGuard::isSuperAdmin()) {
                $this->error('Only a Super Admin can permanently delete an admin with the Super Admin role.');

                return;
            }
            $this->service->deleteData($adminId, forceDelete: true);
            $this->showDeleteModal = false;
            $this->selectedId = null;
            $this->resetPage();
            $this->success('Data permanently deleted successfully');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->error($e->getMessage());
        } catch (\Throwable $e) {
            $this->error('Failed to delete data.');
            Log::error('Failed to delete data: '.$e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $adminId = decrypt($encryptedId);
            $target = Admin::withTrashed()->find($adminId);
            $superAdminRoleId = Role::getSuperAdminRoleId();
            if ($target && $superAdminRoleId !== null && (int) $target->role_id === $superAdminRoleId && ! SuperAdminGuard::isSuperAdmin()) {
                $this->error('Only a Super Admin can restore an admin with the Super Admin role.');

                return;
            }
            $this->service->restoreData($adminId);
            $this->success('Data restored successfully');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->error($e->getMessage());
        } catch (\Throwable $e) {
            $this->error('Failed to restore data.');
            Log::error('Failed to restore data: '.$e->getMessage());
            throw $e;
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select data and an action');

            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'forceDelete' => $this->bulkForceDelete(),
                'bulkRestore' => $this->bulkRestore(),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->error($e->getMessage());
        } catch (\Exception $e) {
            $this->error('Failed to execute bulk action.');
            Log::error('Failed to execute bulk action: '.$e->getMessage());
            throw $e;
        }
    }

    protected function bulkRestore(): void
    {
        $superAdminRoleId = Role::getSuperAdminRoleId();
        if ($superAdminRoleId !== null && ! SuperAdminGuard::isSuperAdmin()) {
            $targets = Admin::withTrashed()->whereIn('id', $this->selectedIds)->get();
            if ($targets->contains(fn (Admin $a) => (int) $a->role_id === $superAdminRoleId)) {
                $this->error('Only a Super Admin can restore admins with the Super Admin role.');

                return;
            }
        }
        $count = count($this->selectedIds);
        $this->service->bulkRestoreData($this->selectedIds);
        $this->success("{$count} Datas restored successfully");
    }

    protected function bulkForceDelete(): void
    {
        $superAdminRoleId = Role::getSuperAdminRoleId();
        if ($superAdminRoleId !== null && ! SuperAdminGuard::isSuperAdmin()) {
            $targets = Admin::withTrashed()->whereIn('id', $this->selectedIds)->get();
            if ($targets->contains(fn (Admin $a) => (int) $a->role_id === $superAdminRoleId)) {
                $this->error('Only a Super Admin can permanently delete admins with the Super Admin role.');

                return;
            }
        }
        $count = count($this->selectedIds);
        $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Datas permanently deleted successfully");
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
        $data = $this->service->getTrashedPaginatedData(
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
