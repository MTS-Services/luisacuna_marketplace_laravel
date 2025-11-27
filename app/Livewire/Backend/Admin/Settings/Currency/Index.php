<?php

namespace App\Livewire\Backend\Admin\Settings\Currency;

use App\Enums\CurrencyStatus;
use App\Services\CurrencyService;
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
    public $showDefaultModal = false;
    public $defaultId = null;
    public $currentDefaultCurrency = null;

    protected CurrencyService $service;

    public function boot(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('creater_admin');

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
                'key' => 'is_default',
                'label' => 'Default',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->is_default 
                        ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Yes</span>'
                        : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">No</span>';
                }
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
                'label' => 'Show',
                'route' => 'admin.as.currency.show',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.as.currency.edit',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Set as Default',
                'method' => 'confirmSetDefault',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.settings.currency.index', [
            'datas' => $datas,
            'statuses' => CurrencyStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmSetDefault($id): void
    {
        try {
            $decryptedId = decrypt($id);
            
            // Check if currency exists
            if (!$this->service->exists($decryptedId)) {
                $this->error('Currency not found');
                return;
            }
            
            // Get the currency to check if it's already default
            $currency = $this->service->findData($decryptedId);
            if ($currency->is_default) {
                $this->warning('This currency is already set as default');
                return;
            }
            
            // Get existing default currency
            $existingDefault = $this->service->getDefaultCurrency();
            
            $this->defaultId = $id;
            $this->currentDefaultCurrency = $existingDefault;
            $this->showDefaultModal = true;
            
        } catch (\Exception $e) {
            $this->error('Failed to process request: ' . $e->getMessage());
        }
    }

    public function setAsDefault(): void
    {
        try {
            if (!$this->defaultId) {
                $this->warning('No currency selected');
                return;
            }

            $decryptedId = decrypt($this->defaultId);
            
            // Pass admin ID explicitly
            $result = $this->service->setDefaultCurrency($decryptedId, admin()->id);
            
            if ($result['success']) {
                $this->reset(['defaultId', 'showDefaultModal', 'currentDefaultCurrency']);
                $this->success($result['message']);
            } else {
                $this->warning($result['message']);
            }
            
        } catch (\Exception $e) {
            $this->error('Failed to set default currency: ' . $e->getMessage());
        }
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
            $dataStatus = CurrencyStatus::from($status);

            match ($dataStatus) {
                CurrencyStatus::ACTIVE => $this->service->updateStatusData($id, CurrencyStatus::ACTIVE),
                CurrencyStatus::INACTIVE => $this->service->updateStatusData($id, CurrencyStatus::INACTIVE),
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
                'active' => $this->bulkUpdateStatus(CurrencyStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(CurrencyStatus::INACTIVE),
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
        $count =  $this->service->bulkDeleteData($this->selectedIds);
        $this->success("{$count} Data deleted successfully");
    }

    protected function bulkUpdateStatus(CurrencyStatus $status): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkUpdateStatus($this->selectedIds, $status);
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