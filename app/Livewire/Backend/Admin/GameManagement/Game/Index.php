<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use Livewire\Component;

use App\Services\GameService;

use App\Enums\GameStatus;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;


class Index extends Component
{

    use WithDataTable, WithNotification;


    protected GameService $service;
    public string $bulkAction = '';
    public $statusFilter = '';
    public $showBulkActionModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;


    public function boot(GameService $service)
    {
        $this->service = $service;
    }
    public function render()
    {

        $datas = $this->service->getPaginatedData(
            $this->perPage,
            $this->getfilters(),
        )->load('creater_admin');


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
                'label' => 'View', 
                'route' => 'admin.gm.game.view', 
                'encrypt' => true
            ],
            [
                'key' => 'id', 
                'label' => 'Edit', 
                'route' => 'admin.gm.game.edit', 
                'ecrypt' => true
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
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactivate', 'label' => 'Inactive'],
            ['value' => 'upcoming', 'label' => 'Upcoming'],
        ];



        return view(
            'livewire.backend.admin.game-management.game.index',
            [
                'datas' => $datas,
                'columns' => $columns,
                'actions' => $actions,
                'bulkActions' => $bulkActions,
                'statuses' =>  GameStatus::options()
            ]
        );
    }

    // Confirm Delete form Single Delete

    public function confirmDelete($encrypted_id)
    {
        $this->deleteId = $encrypted_id;
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
            $dataStatus = GameStatus::from($status);

            match ($dataStatus) {
                GameStatus::ACTIVE => $this->service->updateStatusData($id, GameStatus::ACTIVE),
                GameStatus::INACTIVE => $this->service->updateStatusData($id, GameStatus::INACTIVE),
                GameStatus::UPCOMING => $this->service->updateStatusData($id, GameStatus::UPCOMING),
                default => null,
            };

            $this->success('Data status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }


    public function getfilters()
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }



    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select categories and an action');
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
                'activate' => $this->bulkUpdateStatus(GameStatus::ACTIVE),
                'inactivate' => $this->bulkUpdateStatus(GameStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            dd('Bulk action failed: ' . $e->getMessage());
        }
    }

    public function bulkDelete(): void
    {
        try {

            $count =    $this->service->bulkDeleteData($this->selectedIds,  admin()->id);

            $this->success("($count) Datas deleted successfully");
        } catch (\Exception $e) {

            $this->error('Failed to delete data.');

            log::error('Failed to delete data: ' . $e->getMessage());
        }
    }

    public function bulkUpdateStatus(GameStatus $status): void
    {

        try {

            $count =  $this->service->bulkUpdateStatus($this->selectedIds, $status, admin()->id);

            $this->success("($count)  Status change successfully");

        } catch (\Exception $e) {

            $this->error('Failed to change status.');
        }
    }


    protected function getSelectableIds(): array
    {
        return $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }
}
