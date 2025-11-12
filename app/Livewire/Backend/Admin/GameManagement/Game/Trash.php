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

        $datas = $this->service->getTrashedPaginatedData($this->perPage, $this->getFilters());



        $columns = [

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
                'key' => 'creater_id',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater?->name ?? 'System';
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
            $this->service->restoreData(decrypt($encrypted_id), admin()->id);

            $this->success('Data restored successfully');
        } catch (\Exception $e) {

            $this->error('Failed to restore data.');

            Log::error('Failed to restore data: ' . $e->getMessage());
        }
    }

    public function confirmDelete($encrypted_id)
    {
        $this->showDeleteModal = true;
        $this->deleteId = $encrypted_id;
    }

    public function delete()
/*************  ✨ Windsurf Command 🌟  *************/
    /**
     * Delete a game data
     *
     * @return void
     */
    public function delete()
    {

        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }
            $this->service->deleteData(decrypt($this->deleteId), true);
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            // Log the error message

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

            // Display the error message to the user
            $this->error('Failed to delete data.');
        }
    }

    /**
     * Confirm the bulk action
     *
     * @return void
     */
    public function confirmBulkAction(): void
/*******  f43a0f48-6c09-47ac-87b8-cbb62e8401a2  *******/
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
            $count = $this->service->bulkForceDeleteData($this->selectedIds);

            $this->success("{$count} Datas deleted successfully");
        } catch (\Exception $e) {

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

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
            $count =  $this->service->bulkRestoreData($this->selectedIds, admin()->id);

            $this->success("{$count} Data restored successfully");
        } catch (\Exception $e) {

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

            $this->error('Failed to delete data.');
        }
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }
}
