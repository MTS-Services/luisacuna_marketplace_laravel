<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\GameStatus;
use App\Services\GameService;
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

    public $deleteId = null;

    protected GameService $service;

    public function boot(GameService $service)
    {
        $this->service = $service;
    }
    public function render()
    {

        $datas = $this->service->trashedPaginatedDatas(
            $this->perPage,
            $this->getfilters(),
        );
        $datas->load('deleter_admin');

        $columns = [
            [
                'key' => 'logo',
                'label' => 'Avatar',
                'format' => function ($data) {
                    return $data->logo
                        ? '<img src="' . storage_url($data->logo) . '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
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
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">'  .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'deleted_at',
                'label' => 'Deleted Date',
                'sortable' => true,
                'format' => function ($data) {

                    return $data->deleted_at_formatted;
                }
            ],
            [
                'key' => 'deleter_id',
                'label' => 'Deleted By',
                'format' => function ($data) {
                    return $data->deleter_admin?->name ?? 'System';
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
                'label' => 'Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'restore', 'label' => 'Restore'],
            ['value' => 'delete', 'label' => 'Delete'],
        ];



        return view(
            'livewire.backend.admin.game-management.game.trash',
            [
                'data' => $datas,
                'columns' => $columns,
                'actions' => $actions,
                'bulkActions' => $bulkActions,
                'statuses' =>  GameStatus::options()
            ]
        );
    }


    public function getFilters()
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    public function restore($encrypted_id)
    {

        try {
            $this->service->restore(decrypt($encrypted_id));
            $this->success('Data restored successfully');
        } catch (\Exception $e) {
            log_error($e);
            $this->error('Failed to restore data.');
        }
    }

    public function confirmDelete($encrypted_id)
    {
        $this->showDeleteModal = true;
        $this->deleteId = $encrypted_id;
    }

    public function delete()
    {

        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }
            $this->service->delete(decrypt($this->deleteId), true);
            $this->reset(['deleteId', 'showDeleteModal']);
            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            log_error($e);
            $this->error('Failed to delete data.');
        }
    }
    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Games and an action');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkForceDelete(),
                'restore' => $this->bulkRestore(),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    public function bulkForceDelete(): void
    {

        try {
            $count = $this->service->bulkDelete($this->selectedIds, true);
            $this->success("{$count} Datas deleted successfully");
        } catch (\Exception $e) {
            log_error($e);
            $this->error('Failed to delete data.');
        }
    }

    public function bulkRestore(): void
    {
        try {
            if (! count($this->selectedIds)) {
                $this->warning('No data selected');
                return;
            }
            $count =  $this->service->bulkRestore($this->selectedIds);

            $this->success("{$count} Data restored successfully");
        } catch (\Exception $e) {
            log_error($e);
            $this->error('Failed to delete data.');
        }
    }

    protected function getSelectableIds(): array
    {
        return $this->service->trashedPaginatedDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }
}
