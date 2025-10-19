<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Category;

use App\Services\Game\GameCategoryService;
use App\Traits\Livewire\WithDataTable;
use Livewire\Component;

class Trash extends Component
{
    use WithDataTable;

    public $statusFilter = '';
    protected GameCategoryService $gameCategoryService;
    public $deleteGameCategoryId;
    public bool $showDeleteModal = false;
    public bool $showRestoreModal = false;
    public $showBulkActionModal = false;
    public $bulkAction = '';

  
    public function boot(GameCategoryService $gameCategoryService)
    {

        $this->gameCategoryService = $gameCategoryService;
    }
    public function render()
    {
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
                'format' => function ($category) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $category->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $category->created_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($category) {
                    return $category->creater_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $category->creater_admin->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'Restore', 'method' => 'restoreDelete'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];

        $bulkActions = [
            ['value' => 'restore', 'label' => 'Restore'],
            ['value' => 'delete', 'label' => 'Delete'],
        ];

        // $category = GameCategory::onlyTrashed()->get();
        $categories = $this->gameCategoryService->paginateOnlyTrashed(

            perPage: $this->perPage,
            filters: $this->getFilters()
        );
        return view('livewire.backend.admin.components.game-management.category.trash', [
            'categories' => $categories,
            'statuses' => [],
            'columns' =>  $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($id)
    {

        $this->showDeleteModal = true;
        $this->deleteGameCategoryId = $id;
    }


    public function cancelDelete()
    {
        $this->showDeleteModal = false;
    }

    public function delete()
    {
        $this->showDeleteModal = false;

        $this->gameCategoryService->deleteCategory($this->deleteGameCategoryId, true);
    }

    public function restoreDelete($id)
    {

        $this->gameCategoryService->restoreDelete($id, false);
    }

    public function getFilters()
    {
        return [
            'search' => $this->search,
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
        $count = $this->gameCategoryService->bulkDeleteCategories($this->selectedIds, true);
       
    }

    public function bulkRestore(): void
    {
        $count = $this->gameCategoryService->BulkCategoryRestore($this->selectedIds,);
        // $this->success("{$count} categories updated successfully");
    }
}
