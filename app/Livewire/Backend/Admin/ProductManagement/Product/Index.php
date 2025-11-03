<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use Livewire\Component;
use App\Enums\ProductsStatus;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Services\Product\ProductService;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected ProductService $service;

    public function boot(ProductService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->getPaginatedData(
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
                'key' => 'description',
                'label' => 'Description',
                'sortable' => true
            ],
            [
                'key' => 'comission_rate',
                'label' => 'Comission Rate',
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
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->createdBy?->name ?? 'System';
                }
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
                'label' => 'Edit',
                'route' => 'admin.pm.product.edit',
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
        return view('livewire.backend.admin.product-management.product.index', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => ProductsStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }
    // public function confirmDelete($id): void
    // {
    //     $this->deleteId = $id;
    //     $this->showDeleteModal = true;
    // }
    // public function delete()
    // {
    //     try {
    //         if (!$this->deleteId) {
    //             $this->warning('No data selected');
    //             return;
    //         }
    //         $this->service->deleteData(decrypt($this->deleteId));
    //         $this->reset(['deleteId', 'showDeleteModal']);
    //         $this->success('Data deleted successfully');
    //     } catch (\Exception $e) {
    //     }
    // }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }
    // public function changeStatus($id, $status): void
    // {
    //     try {
    //         $productStatus = ProductsStatus::from($status);

    //         match ($productStatus) {
    //             ProductsStatus::ACTIVE => $this->service->updateStatusData($id, ProductsStatus::ACTIVE),
    //             ProductsStatus::INACTIVE => $this->service->updateStatusData($id, ProductsStatus::INACTIVE),
    //             default => null,
    //         };

    //         $this->success('Data status updated successfully');
    //     } catch (\Exception $e) {
    //         $this->error('Failed to update status: ' . $e->getMessage());
    //     }
    // }

    // public function confirmBulkAction(): void
    // {
    //     if (empty($this->selectedIds) || empty($this->bulkAction)) {
    //         $this->warning('Please select data and an action');
    //         Log::info('No data selected or no bulk action selected');
    //         return;
    //     }

    //     $this->showBulkActionModal = true;
    // }

    // public function executeBulkAction(): void
    // {
    //     $this->showBulkActionModal = false;

    //     try {
    //         match ($this->bulkAction) {
    //             'delete' => $this->bulkDelete(),
    //             'active' => $this->bulkUpdateStatus(ProductsStatus::ACTIVE),
    //             'inactive' => $this->bulkUpdateStatus(ProductsStatus::INACTIVE),
    //             default => null,
    //         };

    //         $this->selectedIds = [];
    //         $this->selectAll = false;
    //         $this->bulkAction = '';
    //     } catch (\Exception $e) {
    //         $this->error('Bulk action failed: ' . $e->getMessage());
    //     }
    // }


    // protected function bulkDelete(): void
    // {
    //     $count = count($this->selectedIds);
    //     $this->service->bulkDeleteData($this->selectedIds);
    //     $this->success("{$count} Data deleted successfully");
    // }

    // protected function bulkUpdateStatus(ProductStatus $status): void
    // {
    //     $count = count($this->selectedIds);
    //     $this->service->bulkUpdateStatus($this->selectedIds, $status);
    //     $this->success("{$count} Data updated successfully");
    // }

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
