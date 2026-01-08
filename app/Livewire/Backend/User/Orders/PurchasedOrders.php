<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Enums\OrderStatus;
use Livewire\WithPagination;
use App\Services\OrderService;
use App\Traits\WithPaginationData;

class PurchasedOrders extends Component
{
    use WithPaginationData;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    // public $perPage = 2;
    public $status = null;
    public $order_date;


    protected OrderService $service;

    public function boot(OrderService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            filters: $this->getFilters()
        );
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
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->source->user->username]) . ' " target="_blank"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">' . $order->source->user->full_name . '</span></a>'
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
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'format' => fn($order) => $order?->quantity
            ],
            [
                'key' => 'grand_total',
                'label' => 'Price',
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' .  currency_symbol() . currency_exchange($order->total_amount) . '</span>'
            ],
        ];

        $this->PaginationData($datas);
        return view('livewire.backend.user.orders.purchased-orders', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => OrderStatus::options(),
        ]);
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? null,
            'status' => $this->status ?? null,
            'exclude_status' => OrderStatus::INITIALIZED,
            'order_date' => $this->order_date ?? null,
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'user_id' => user()->id,
        ];
    }
}
