<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Storage;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    protected CategoryService $service;
    public $selectedId;
    public bool $showDeleteModal = false;
    public bool $showRestoreModal = false;
    public $showBulkActionModal = false;
    public $bulkAction = '';


    public function boot(CategoryService $service)
    {

        $this->service = $service;
    }
    public function render()
    {
        $columns = [

              [
                'key' => 'icon',
                'label' => 'icon',
                'format' => function ($data) {
                    return $data->icon
                        ? '<img src="' . Storage::url($data->icon) . '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
                        : '<div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">' . strtoupper(substr($data->name, 0, 2)) . '</div>';
                }
            ],
            [
                'key' => 'name',
                'label' => 'Name',
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
                'key' => 'layout',
                'label' => 'Layout',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->layout->color() . '">' .
                        $data->layout->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'deleted_at',
                'label' => 'Deleted',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->deleted_at_formatted;
                }
            ],
            [
                'key' => 'deleted_by',
                'label' => 'Deleted By',
                'format' => function ($data) {
                    return $data->deleter_admin?->name ?? 'System';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Permanently Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'forceDelete', 'label' => 'Permanently Delete'],
            ['value' => 'bulkRestore', 'label' => 'Restore'],
        ];

        // $category = GameCategory::onlyTrashed()->get();
        $datas = $this->service->getPaginatedData(

            perPage: $this->perPage,
            filters: $this->getFilters(),
            trashed: true
        );
        return view('livewire.backend.admin.game-management.category.trash', [
            'datas' => $datas,
            'statuses' => [],
            'columns' =>  $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        if (!$encryptedId) {
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
            $this->service->deleteData(decrypt($this->selectedId), forceDelete: true);
            $this->showDeleteModal = false;
            $this->selectedId = null;
            $this->resetPage();
            $this->success('Data permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete data.');
            Log::error('Failed to delete data: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId));

            $this->success('Data restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore data.');
            Log::error('Failed to restore data: ' . $e->getMessage());
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
        } catch (\Exception $e) {
            $this->error('Failed to execute bulk action.');
            Log::error('Failed to execute bulk action: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function bulkRestore(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkRestoreData($this->selectedIds);
        $this->success("{$count} Datas restored successfully");
    }

    protected function bulkForceDelete(): void
    {
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
        $data = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters(),
            trashed: true
        );
        return array_column($data->items(), 'id');
    }


    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
