<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use Livewire\Component;
use App\Services\OrderService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class AllOrders extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteCategoryId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $deleteId = null;

    protected OrderService $service;

    public function boot(OrderService $service)
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
                'key' => 'order_id',
                'label' => 'Order ID',
                'sortable' => true,
            ],
            [
                'key' => 'source_id',
                'label' => 'Product Title',
                'sortable' => true,
                'format' => fn($order) => '
                <div class="flex items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . $order->source->name .
                    '</h3>
                    </div>
                </div>'
            ],
            [
                'key' => 'user_id',
                'label' => 'Buyer',
                'sortable' => true,
                'format' => fn($order) => $order->user->full_name,
            ],
            [
                'key' => 'source_id',
                'label' => 'Seller',
                'sortable' => true,
                'format' => fn($order) => $order->source->user->full_name,
            ],
            [
                'key' => 'status',
                'label' => 'Order status',
                'sortable' => true,
                // 'badge' => true,
                'format' => function ($order) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-text-primary text-xs font-medium badge bg-pink-500 ' . $order->status->value . '">' .
                        $order->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'total_amount',
                'label' => 'Price ($)',
                'sortable' => true,
                'format' => fn($order) => currency_exchange($order->total_amount),
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($order) {
                    return $order->created_at_formatted;
                }
            ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'Show',
                // 'route' => '',
                'encrypt' => true
            ],

        ];
        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],

        ];
        return view('livewire.backend.admin.order-management.all-orders', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
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
            'status'         => $this->statusFilter,
            'sort_field'     => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }


    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
