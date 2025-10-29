<?php

namespace App\Livewire\Backend\Admin\Components\Settings\Currency;

use App\Enums\CurrencyStatus;
use App\Services\CurrencyService;
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

    protected $listeners = ['CurrencyDeleted' => '$refresh', 'CurrencyRestored' => '$refresh', 'CurrencyUpdated' => '$refresh'];

    protected CurrencyService $currencyService;

    public function boot(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function render()
    {
        $datas = $this->currencyService->getTrashedPaginatedData(
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
                'key' => 'code',
                'label' => 'Code',
                'sortable' => true
            ],
            [
                'key' => 'symbol',
                'label' => 'Symbol',
                'sortable' => true
            ],
            [
                'key' => 'exchange_rate',
                'label' => 'Exchange Rate',
                'sortable' => true,
                'format' => function ($data) {
                    return number_format($data->exchange_rate, $data->decimal_places);
                }
            ],
            [
                'key' => 'decimal_places',
                'label' => 'Decimal Places',
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
                'label' => 'Restore',
                'method' => 'restore'
            ],
            [
                'key' => 'id',
                'label' => 'Permanent Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'forceDelete', 'label' => 'Permanent Delete'],
        ];

        return view('livewire.backend.admin.components.settings.currency.trash', [
            'datas' => $datas,
            'statuses' => CurrencyStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($id): void
    {
        if (!$id) {
            $this->error('No Currency selected');
            $this->resetPage();
            return;
        }
        $this->selectedId = $id;
        $this->showDeleteModal = true;
    }

    public function forceDelete(): void
    {
        try {
            $this->currencyService->deleteData($this->selectedId, forceDelete: true);
            $this->showDeleteModal = false;
            $this->selectedId = null;
            $this->resetPage();
            $this->success('Currency permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete currency.');
            Log::error('Failed to delete currency: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($id): void
    {
        try {
            $this->currencyService->restoreData($id);

            $this->success('Currency restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore currency.');
            Log::error('Failed to restore currency: ' . $e->getMessage());
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
            $this->warning('Please select currency and an action');
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
        $count = $this->currencyService->bulkRestoreData($this->selectedIds);
        $this->success("{$count} Currencies restored successfully");
    }

    protected function bulkForceDelete(): void
    {
        $count = $this->currencyService->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Currencies permanently deleted successfully");
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
        return $this->currencyService->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
