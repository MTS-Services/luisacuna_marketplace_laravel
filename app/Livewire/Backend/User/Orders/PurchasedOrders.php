<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Enums\OrderStatus;
use App\Services\OrderService;
use Livewire\WithPagination;

class PurchasedOrders extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;
    public $status = null;


    protected OrderService $service;

    public function boot(OrderService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        // Table columns configuration for orders
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        // dd($datas);  
        $columns = [
            [
                'key' => 'id',
                'label' => 'Order Name',
                'format' => fn($order) => '
                <div class="flex items-center gap-3">
                    <div class="w-15 h-15  rounded-lg flex-shrink-0">
                        <img src="' . storage_url($order?->source?->game?->logo) . '"
                            alt="' . $order->source->name . '" 
                            class="w-full h-full rounded-lg object-cover" />
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . $order->source->name .
                    '</h3>
                        <p class="text-xs text-text-primary/80 truncate xxs:block py-1">'
                    . $order?->soruce?->name .
                    '</p>
                        <a href="' . ($order->status->value === 'cancelled'
                        ? route('user.order.cancel', ['orderId' => $order->order_id])
                        : route('user.order.complete', ['orderId' => $order->order_id])
                    ) . '"
                        class="text-bg-pink-500 text-xs">
                            View Details 
                            <flux:icon name="arrow-right" class="w-4 h-4" />
                        </a>
                    </div>
                </div>
        '
            ],

            [
                'key' => 'source_id',
                'label' => 'Seller',
                // 'sortable' => true,
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->source->user->username]) . '"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $order->source->user->full_name . '</span></a>'
            ],
            [
                'key' => 'created_at',
                'label' => 'Ordered date',
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'status',
                'label' => 'Order status',
                // 'badge' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-text-primary text-xs font-medium badge ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'format' => fn($order) => $order->total_quantity ?? 1
            ],
            [
                'key' => 'grand_total',
                'label' => 'Price ($)',
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' . currency_exchange($order->total_amount) . '</span>'
            ],
        ];

        return view('livewire.backend.user.orders.purchased-orders', [
            'datas' => $datas,
            'columns' => $columns,
            // 'pagination' => $pagination,
            'statuses' => OrderStatus::options(),
        ]);
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? null,
             'status' => $this->status ?? null,
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'user_id' => user()->id,
        ];
    }
}
