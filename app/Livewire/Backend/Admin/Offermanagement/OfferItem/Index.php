<?php

namespace App\Livewire\Backend\Admin\OfferManagement\OfferItem;

use App\Services\OfferItemService;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;


class Index extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected OfferItemService $service;

    public function boot(OfferItemService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('deliveryMethod');

        $columns = [
            [
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'deliveryMethod.name',
                'label' => 'Delivery Method',
                'sortable' => true
            ],
            [
                'key' => 'price',
                'label' => 'Price',
                'sortable' => true
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'sortable' => true
            ],
            [
                'key' => 'delivery_time_formatted',
                'label' => 'Delivery Time',
                'sortable' => true
            ],

            [
                'key' => 'creater_id',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . getAuditorName($data->creater) . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                },
            ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'Show',
                'route' => 'admin.pm.product.show',
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

        ];
        return view('livewire.backend.admin.offer-management.offer-item.index', [
            'datas' => $datas,
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
    public function delete()
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
        $count = count($this->selectedIds);
        $this->service->bulkDeleteData($this->selectedIds);
        $this->success("{$count} Data deleted successfully");
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
        return $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
