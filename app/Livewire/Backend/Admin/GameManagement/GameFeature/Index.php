<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameFeature;

use App\Enums\GameFeatureStatus;
use App\Services\GameFeatureService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

  
    protected GameFeatureService $service;
    public function boot(GameFeatureService $service)
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
             [
                'key' => 'icon',
                'label' => 'icon',
                'format' => function ($data) {
                    return $data->icon
                        ? '<img src="' .Storage::url($data->icon ). '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
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
            [
                'key' => 'restored_by',
                'label' => 'Restored By',
                'format' => function ($data) {
                    return $data->restorer_admin?->name ?? 'N/A';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Show',
                'route' => 'admin.gm.server.view',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.gm.server.edit',
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


        return view('livewire.backend.admin.game-management.game-feature.index', [
            'datas' => $datas,
            'statuses' => GameFeatureStatus::options(),
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
            $dataStatus = GameFeatureStatus::from($status);

            match ($dataStatus) {
                GameFeatureStatus::ACTIVE => $this->service->updateStatusData($id, GameFeatureStatus::ACTIVE),
                GameFeatureStatus::INACTIVE => $this->service->updateStatusData($id, GameFeatureStatus::INACTIVE),
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
                'active' => $this->bulkUpdateStatus(GameFeatureStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(GameFeatureStatus::INACTIVE),
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

    protected function bulkUpdateStatus(GameFeatureStatus $status): void
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
