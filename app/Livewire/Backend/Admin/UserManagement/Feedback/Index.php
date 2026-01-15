<?php

namespace App\Livewire\Backend\Admin\UserManagement\Feedback;

use Livewire\Component;

use App\Enums\FeedbackType;
use Illuminate\Support\Str;
use App\Services\FeedbackService;
use App\Traits\Livewire\WithDataTable;

class Index extends Component
{
    use WithDataTable;


    protected FeedbackService $service;


    public $userId;
    public $statusFilter = '';

    public $showModal = false;
    public $selectedFeedback = null;


    public function boot(FeedbackService $service)
    {
        $this->service = $service;
    }
    public function mount($userId)
    {
        $this->userId = decrypt($userId);
    }

    public function view($id)
    {
        $this->selectedFeedback = $this->service->findData($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedFeedback = null;
    }

    public function render()
    {


        $datas = $this->service->getUserPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters(),
            userId: $this->userId,
        );


        $columns = [
            [
                'key' => 'order_id',
                'label' => 'Order ID',
                'sortable' => true,
                'format' => fn($data) => '<span class="text-text-white text-xs xxs:text-sm md:text-base truncate">' . $data->order?->order_id . '</span>'
            ],
            [
                'key' => 'author_id',
                'label' => 'Sender',
                'sortable' => true,
                'format' => fn($data) => '<a href="' . route('profile', ['username' => $data->author->username]) . '" target="_blank" class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $data->author->username . '</a>'
            ],
            [
                'key' => 'message',
                'label' => 'Message',
                'sortable' => true,
                'format' => fn($data) =>
                '<span title="' . e($data->message) . '">' .
                    Str::limit($data->message, 50) .
                    '</span>',

            ],
            [
                'key' => 'type',
                'label' => 'Type',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge badge-soft ' . $data->type->color() . '">' .
                        $data->type->label() .
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
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'method' => 'view',
            ],
        ];
        return view('livewire.backend.admin.user-management.feedback.index', [
            'datas' => $datas,
            'columns' => $columns,
            'types' => FeedbackType::options(),
            'actions' => $actions
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
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
            'type' => $this->statusFilter
        ];
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
