<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalMethod;

use App\Models\WithdrawalMethod;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithDataTable, WithFileUploads, WithNotification;

    public $showDeleteModal = false;

    public $deleteId = null;

    public $statusFilter = '';

    protected WithdrawalMethodService $service;

    public WithdrawalMethod $data;

    public function boot(WithdrawalMethodService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: 12,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'icon',
                'label' => 'Icon',
                'format' => function ($data) {
                    return '<div class="flex items-center justify-center text-xs text-gray-500">
                        ' . (!empty($data->icon)
                        ? '<img src="' . storage_url($data->icon) . '"
                                   alt="' . e($data->name) . '"
                                   class="h-8 w-8 object-contain rounded">'
                        : '<span>No Icon</span>') . '
                    </div>';
                },
            ],
            [
                'key' => 'name',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'code',
                'label' => 'Code',
                'sortable' => true,
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
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.wm.method.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.wm.method.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete', 'encrypt' => true],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.withdrawal-management.withdrawal-method.index', [
            'datas' => $datas,
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
            perPage: 12,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }
}
