<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Achievement;

use Livewire\Component;
use App\Enums\AchievementStatus;
use Illuminate\Support\Facades\Log;
use App\Services\AchievementService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Trash extends Component
{

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $selectedId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    use WithDataTable, WithNotification;

    protected AchievementService $service;

    public function boot(AchievementService $service)
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
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'rank_id',
                'label' => 'Rank',
                'sortable' => true,
                'format' => function ($data) {
                    return optional($data->rank)->name ?? 'N/A';
                }
            ],
            [
                'key' => 'category_id',
                'label' => 'Category',
                'sortable' => true,
                'format' => function ($data) {
                    return optional($data->category)->name ?? 'N/A';
                }
            ],
            [
                'key' => 'target_value',
                'label' => 'Target Value',
                'sortable' => true
            ],
            [
                'key' => 'point_reward',
                'label' => 'Point Reward',
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
                'method' => 'restore',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Permanent Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'forceDelete', 'label' => 'Permanent Delete'],
        ];
        return view('livewire.backend.admin.reward-management.achievement.trash',[
            'datas' => $datas,
            'statuses' => AchievementStatus::options(),
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
        $data = $this->service->getTrashedPaginatedData(
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
