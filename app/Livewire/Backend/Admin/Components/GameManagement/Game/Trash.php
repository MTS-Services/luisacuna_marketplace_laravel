<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Game;

use App\Enums\GameStatus;
use App\Services\Game\GameService;
use App\Traits\Livewire\WithDataTable;
use Livewire\Component;

class Trash extends Component
{
    use WithDataTable;


    protected GameService $gameService;
    public string $bulkAction = '';
    public $statusFilter = '';
    public $showBulkActionModal = false;

    public $showDeleteModal = false;
    public $deleteGameId = [];
    

    public function boot(GameService $gameService)  
    {
        $this->gameService = $gameService;
    }
    public function render()
    {   

        $games = $this->gameService->OnlyTrashedPaginate( $this->perPage, $this->filters());

        
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
                'format' => function ($arg) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $arg->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $arg->created_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($arg) {
                    return $arg->creater_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $arg->creater_admin->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

            $actions = [
                ['key' => 'id', 'label' => 'Restore', 'method' => 'restore'],
                ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
            ];

            $bulkActions = [
                ['value' => 'restore', 'label' => 'Restore'],
                ['value' => 'delete', 'label' => 'Delete'],
            ];



        return view('livewire.backend.admin.components.game-management.game.trash',
        [
            'games' => $games,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
            'bulkAction'  => $this->bulkAction,
            'statuses' =>  GameStatus::options()
        ]
    );
    }


    public function filters()
    {
         return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    public function restore($id)
    {
        $this->gameService->restoreGame($id);
    }
    
    public function confirmDelete($id)
    {
        $this->showDeleteModal = true;
        $this->deleteGameId[] = $id;
    }

    public function delete(){
        $this->showDeleteModal = false;

        $this->gameService->deleteGame($this->deleteGameId, true);
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
                'delete' => $this->bulkDelete(),
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

    public function bulkDelete(): void
    {

         $this->gameService->deleteGame($this->selectedIds, true);
       
    }

    public function bulkRestore(): void
    {
         $this->gameService->bulkRestoreGame($this->selectedIds);
    }

    protected function getSelectableIds(): array
    {
        return $this->gameService->OnlyTrashedPaginate(
            perPage: $this->perPage,
            filters: $this->filters()
        )->pluck('id')->toArray();
    }

}
