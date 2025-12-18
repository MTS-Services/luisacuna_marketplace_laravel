<?php

namespace App\Livewire\Backend\Admin\ChatManagement;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;





    public function render()
    {
        $datas = $this->service->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true
            ],
            [
                'key' => 'product.name',
                'label' => 'Product Name',
                'format' => fn($data) => $data->product?->name ?? 'N/A'
            ],
            [
                'key' => 'sender',
                'label' => 'Sender',
                'format' => function ($data) {
                    $sender = $data->conversation_participants->first();
                    return $sender?->user?->username ?? 'N/A';
                }
            ],
            [
                'key' => 'receiver',
                'label' => 'Receiver',
                'format' => function ($data) {
                    $receiver = $data->conversation_participants->skip(1)->first();
                    return $receiver?->user?->username ?? 'N/A';
                }
            ],
            [
                'key' => 'last_message',
                'label' => 'Last Message',
                'format' => function ($data) {
                    $lastMessage = $data->messages->first();
                    return $lastMessage ? Str::limit($lastMessage->message_body, 50) : 'No messages';
                }
            ],
            [
                'key' => 'last_message_at',
                'label' => 'Last Message',
                'format' => fn($data) =>
                optional($data->messages->last())->message_body
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Chat',
                'route' => 'admin.chat.chat',
            ],
        ];

        return view('livewire.backend.admin.chat-management.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }



    public function resetFilters(): void
    {
        $this->reset(['search', 'perPage', 'sortField']);
        $this->resetPage();
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return collect($this->service->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        ))->pluck('id')->toArray();
    }
}
