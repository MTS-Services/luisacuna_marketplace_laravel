<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use Livewire\Component;
use App\Enums\OrderStatus;
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
                    . $order->source?->name .
                    '</h3>
                    </div>
                </div>'
            ],
            [
                'key' => 'user_id',
                'label' => 'Buyer',
                'sortable' => true,
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->user?->username]) . '" target="_blank"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $order->user?->full_name . '</span></a>'
            ],
            [
                'key' => 'source_id',
                'label' => 'Seller',
                'sortable' => true,
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->source->user->username]) . '" target="_blank"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $order->source->user->full_name . '</span></a>'
            ],
            [
                'key' => 'status',
                'label' => 'Order status',
                'sortable' => true,
                // 'badge' => true,
                'format' => function ($order) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $order->status->color() . '">' .
                        $order->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'total_amount',
                'label' => 'Price',
                'sortable' => true,
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' . currency_symbol() . $order->total_amount  . '</span>'
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
            // [
            //     'key' => 'order_id',
            //     'label' => 'View',
            //     'x_click' => "\$dispatch('order-detail-modal-open', { orderId: '{value}' }); console.log('open');",

            // ],
             [
                'key' => 'id', 
                'label' => 'View', 
                'route' => 'admin.orders.show', 
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
            'exclude_status' => OrderStatus::INITIALIZED,
            'sort_field'     => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }


    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
