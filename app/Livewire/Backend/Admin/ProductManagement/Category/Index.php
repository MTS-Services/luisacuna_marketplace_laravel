<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use Livewire\Component;
use App\Services\ProductService;
use App\Enums\ActiveInactiveEnum;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteCategoryId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $deleteId = null;
    public $categoryFilter = null;
    public $categorySlug = null;



    protected ProductService $service;

    public function boot(ProductService $service)
    {
        $this->service = $service;
    }

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }


    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );


        // dd($datas);
        // $datas->load('creater_admin');

        $columns = [

            [
                'key' => 'slug',
                'label' => 'Game',
                'sortable' => false,
                'format' => fn($item) =>
                '<div class="flex items-center gap-3">
                    <img src="' . ($item->games->logo) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->games->slug ?? 'Game') . '">
                    <span class="font-semibold text-text-white">' . ($item->games->slug ?? '-') . '</span>
                </div>'
            ],
             [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true,
                'format' => fn($item) =>
                '<a href="' . route('admin.am.admin.view', encrypt($item->id)) . '" class="font-semibold text-text-white">' . ($item->user->username ?? '-') . '</a>'
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'sortable' => true,
            ],
            [
                'key' => 'price',
                'label' => 'Price',
                'sortable' => true,
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
                'label' => 'Start Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.gm.category.view', 'encrypt' => true],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.product-management.category.index', [
            'categories' => $datas,
            'statuses' => ActiveInactiveEnum::options(),
            // 'layouts' => ::options(),
            'columns' =>  $columns,
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
            $this->service->deleteData(($this->deleteId));
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
            $dataStatus = ActiveInactiveEnum::from($status);

            match ($dataStatus) {
                ActiveInactiveEnum::ACTIVE => $this->service->updateStatusData($id, ActiveInactiveEnum::ACTIVE),
                ActiveInactiveEnum::INACTIVE => $this->service->updateStatusData($id, ActiveInactiveEnum::INACTIVE),
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
                'active' => $this->bulkUpdateStatus(ActiveInactiveEnum::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(ActiveInactiveEnum::INACTIVE),
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

    protected function bulkUpdateStatus(ActiveInactiveEnum $status): void
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
            'categorySlug' => $this->categorySlug ?? null,
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
