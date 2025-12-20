<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Enums\OrderStatus;
use Livewire\WithPagination;
use App\Services\OrderService;

class SoldOrders extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;


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
                'key' => 'name',
                'label' => 'Order Name',
                'format' => fn($order) => '
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 xxs:w-10 xxs:h-10 rounded-lg flex-shrink-0">
                        <img src="' . storage_url($order->product_logo) . '" 
                            alt="' . $order->product_name . '" 
                            class="w-full h-full rounded-lg object-cover" />
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . $order->product_name .
                    '</h3>
                        <p class="text-xs text-text-primary/80 truncate xxs:block py-1">'
                    . 'Cheapest +75%  Discount' .
                    '</p>
                        <a
                            href="/"
                            class="text-bg-pink-500 text-xs"
                        >
                        View Details 
                        <flux:icon name="arrow-right" class="w-4 h-4" />
                        </a>
                    </div>
                </div>
        '
            ],
            [
                'key' => 'type',
                'label' => 'Type',
                'format' => fn($order) => $order->product_type
            ],
            [
                'key' => 'seller',
                'label' => 'Seller',
                'format' => fn($order) => $order->seller_name
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
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-text-primary text-xs font-medium badge bg-pink-500 ' . $data->status->value . '">' .
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
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">$' . number_format($order->total_price, 2) . '</span>'
            ],
        ];

        return view('livewire.backend.user.orders.sold-orders', [
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
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'product_creator_id' => user()->id,
        ];
    }
}
