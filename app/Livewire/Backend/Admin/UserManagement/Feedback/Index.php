<?php

namespace App\Livewire\Backend\Admin\UserManagement\Feedback;

use Livewire\Component;

use App\Enums\FeedbackType;
use App\Services\FeedbackService;
use App\Traits\Livewire\WithDataTable;

class Index extends Component
{
    use WithDataTable;

    public $userId;

    protected FeedbackService $service;


    public function boot(FeedbackService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $users = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
            // filters: [
            //      'target_user_id' => $this->userId, 
            // ]
        );


        $columns = [
            [
                'key' => 'author_id',
                'label' => 'Sender',
                'sortable' => true,
                'format' => fn($data) => '<span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $data->author->full_name . '</span>'
            ],
            [
                'key' => 'type',
                'label' => 'Type',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge ' . $data->type->color() . '">' .
                        $data->type->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'message',
                'label' => 'Message',
                'sortable' => true
            ],
            [
                'key' => 'created_at',
                'label' => 'Created Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];

        return view('livewire.backend.admin.user-management.feedback.index', [
            'datas' => $users,
            'columns' => $columns,
            'types' => FeedbackType::options(),
        ]);
    }


    public function resetFilters(): void
    {
        $this->reset(['search', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }


    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
            'target_user_id' => $this->userId,
        ];
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
