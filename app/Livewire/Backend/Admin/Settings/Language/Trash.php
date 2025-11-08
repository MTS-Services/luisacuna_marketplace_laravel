<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Enums\LanguageStatus;
use App\Services\LanguageService;
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

    protected $listeners = ['languageCreated' => '$refresh', 'languageUpdated' => '$refresh'];

    protected LanguageService $service;

    public function boot(LanguageService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'native_name',
                'label' => 'Native Name',
                'sortable' => true,
                'format' => function ($language) {
                    return $language->native_name
                        ? '<span class="text-sm text-gray-900 dark:text-gray-100">' . $language->native_name . '</span>'
                        : '<span class="text-sm text-gray-400 dark:text-gray-500 italic">N/A</span>';
                }
            ],
            [
                'key' => 'locale',
                'label' => 'Locale',
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
                'key' => 'deleted_at',
                'label' => 'Deleted Date',
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
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
        ];

        return view('livewire.backend.admin.settings.language.trash', [
            'datas' => $datas,
            'statuses' => LanguageStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
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
            $this->success('Currency Data deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete currency.');
            Log::error('Failed to delete currency: ' . $e->getMessage());
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
        return $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
