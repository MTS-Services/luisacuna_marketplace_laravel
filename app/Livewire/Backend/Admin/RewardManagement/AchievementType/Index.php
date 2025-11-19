<?php

namespace App\Livewire\Backend\Admin\RewardManagement\AchievementType;

use App\Models\AchievementType;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Services\AchievementTypeService;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\On;

class Index extends Component
{
    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    public $showCreateModal = false;
    public $showEditModal = false;

    public ?AchievementType $achievementType = null;

    use WithDataTable, WithNotification;

    protected AchievementTypeService $service;

    public function boot(AchievementTypeService $service)
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
                'key' => 'is_active',
                'label' => 'Is Active',
                'sortable' => true,
                'format' => function ($data) {
                    if ($data->is_active) {
                        return '<span class="px-2 py-1 text-xs font-semibold">Active</span>';
                    } else {
                        return '<span class="px-2 py-1 text-xs font-semibold">Inactive</span>';
                    }
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
                'route' => 'admin.rm.achievementType.view',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'method' => 'toggleAchievementTypeEditModal',
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
        return view('livewire.backend.admin.reward-management.achievement-type.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    #[On('hideAchievementTypeModals')]
    public function hideAchievementTypeModals()
    {
        $this->showCreateModal = false;
    }

    #[ON('toggleAchievementTypeEditModal')]
    public function toggleAchievementTypeEditModal($id = null)
    {
        $this->showEditModal = !$this->showEditModal;
        if ($id == null && $this->showEditModal) {
            $this->error('Please select an item first.');
        } else if ($this->showEditModal) {
            $this->achievementType = $this->service->findData(decrypt($id));
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
        $count =  $this->service->bulkDeleteData($this->selectedIds);
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
