<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use App\Enums\CategoryStatus;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
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


    // protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected CategoryService $service;

    public function boot(CategoryService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $datas->load('creater_admin');

        $columns = [
            // [
            //     'key' => 'id',
            //     'label' => 'ID',
            //     'sortable' => true
            // ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'slug',
                'label' => 'Slug',
                'sortable' => true
            ],
            // [
            //     'key' => 'status',
            //     'label' => 'Status',
            //     'sortable' => true,
            //     'format' => function ($admin) {
            //         $colors = [
            //             'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            //             'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            //             'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            //         ];
            //         $color = $colors[$admin->status->value] ?? 'bg-gray-100 text-gray-800';
            //         return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
            //             ucfirst($admin->status->value) .
            //             '</span>';
            //     }
            // ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($data) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $data->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $data->created_at->format('h:i A') . '</div>' .
                        '</div>';
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
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $data->creater_admin?->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.gm.category.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.gm.category.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactivate', 'label' => 'Inactive'],
        ];


        return view('livewire.backend.admin.game-management.category.index', [
            'categories' => $datas,
            'statuses' => [],
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
            $dataStatus = CategoryStatus::from($status);

            match ($dataStatus) {
                CategoryStatus::ACTIVE => $this->service->updateStatusData($id, CategoryStatus::ACTIVE),
                CategoryStatus::INACTIVE => $this->service->updateStatusData($id, CategoryStatus::INACTIVE),
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
                'active' => $this->bulkUpdateStatus(CategoryStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(CategoryStatus::INACTIVE),
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

    protected function bulkUpdateStatus(CategoryStatus $status): void
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
