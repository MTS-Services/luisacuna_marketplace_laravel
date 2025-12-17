<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Announcement;

use App\Enums\CustomNotificationType;
use Livewire\Component;
use App\Services\NotificationService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';

    protected NotificationService $service;

    public function boot(NotificationService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getAnnouncementDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [

            [
                'key' => 'data.title',
                'label' => 'Title',
                'format' => function ($data) {
                    return '<p class="text-text-white text-xs font-semibold mb-2">' . Str::limit($data->data['title'], 20) . '</p>';
                }
            ],
            [
                'key' => 'data.message',
                'label' => 'Message',
                'format' => function ($data) {
                    return '<p class="text-text-white text-xs font-semibold mb-2">' . Str::limit($data->data['message'], 30) . '</p>';
                }
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
                'x_click' => 'showAnnouncement({value})',
                'encrypt' => true
            ],

        ];

        return view('livewire.backend.admin.notification-management.announcement.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'statuses' => CustomNotificationType::options()
        ]);
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection']);
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

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    #[On('refresh-announcement-list')]
    public function refreshList()
    {
        // This will automatically refresh the component
        $this->resetPage();
    }
}
