<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;


use Livewire\Component;
use App\Services\NotificatonService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected NotificatonService $service;

    public function boot(NotificatonService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );


        $columns = [

            [
                'key' => 'data.title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'type',
                'label' => 'Noptification Type',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->type->color() . '">' .
                        $data->type->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Send Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.nm.notification.view',
                'encrypt' => true
            ],

        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'suspend', 'label' => 'Suspend'],
            ['value' => 'pending', 'label' => 'Pending'],
        ];

        return view('livewire.backend.admin.notification-management.notification.index',[
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
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
