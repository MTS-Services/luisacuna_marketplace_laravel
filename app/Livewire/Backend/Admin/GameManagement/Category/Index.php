<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use App\Enums\CategoryStatus;
use App\Enums\CategoryLayout;
use App\Services\CategoryService;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Storage;

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

    protected CloudinaryService $cloudinaryService;
    public function boot(CategoryService $service, CloudinaryService $cloudinaryService)
    {
        $this->service = $service;

        $this->cloudinaryService = $cloudinaryService;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $datas->load('creater_admin');

        $columns = [
[
                'key' => 'icon',
                'label' => 'icon',
                'format' => function ($data) {
                    return $data->icon
                        ? '<img src="' . $this->cloudinaryService->getUrlFromPublicId($data->icon) . '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
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
                'key' => 'created_at',
                'label' => 'Created',
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
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.gm.category.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.gm.category.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];


        return view('livewire.backend.admin.game-management.category.index', [
            'categories' => $datas,
            'statuses' => CategoryStatus::options(),
            'layouts' => CategoryLayout::options(),
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
    public function changeLayout($id, $layout): void
    {
        try {
            $dataLayout = CategoryLayout::from($layout);

            match ($dataLayout) {
                CategoryLayout::LIST_GRID => $this->service->updateLayoutData($id, CategoryLayout::LIST_GRID),
                CategoryLayout::GROUP_GIFT_CARD => $this->service->updateLayoutData($id, CategoryLayout::GROUP_GIFT_CARD),
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
                'list_grid' => $this->bulkUpdateLyout(CategoryLayout::LIST_GRID),
                'group_gift_card' => $this->bulkUpdateLyout(CategoryLayout::GROUP_GIFT_CARD),
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
    protected function bulkUpdateLyout(CategoryLayout $layout): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkUpdateLayout($this->selectedIds, $layout);
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
