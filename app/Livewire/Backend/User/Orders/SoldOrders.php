<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Enums\OrderStatus;
use Livewire\WithPagination;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class SoldOrders extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;
    public $status;
    public $created_at;
    public $search;
    public $months = [];
    public $selectedMonth;
    public $fileType = 'pdf';


    protected OrderService $service;

    public function boot(OrderService $service)
    {
        $this->service = $service;
    }
    public function mount()
    {
        $this->months = $this->generateMonthOptions();
        $this->selectedMonth = $this->months[0]['value'] ?? null;
    }
    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters(),
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
                    . $order?->source?->name .
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
            // [
            //     'key' => 'type',
            //     'label' => 'Type',
            //     'format' => fn($order) => $order->product_type
            // ],
            [
                'key' => 'source_id',
                'label' => 'Seller',
                'sortable' => true,
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
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' .  currency_exchange($order->total_amount)  . '</span>'
            ],
        ];

        return view('livewire.backend.user.orders.sold-orders', [
            'datas' => $datas,
            'columns' => $columns,
            // 'pagination' => $pagination,
            'statuses' => OrderStatus::options(),
        ]);
    }

    private function generateMonthOptions(): array
    {
        $months = [];
        $user = user();

        $startDate = $user->created_at->copy()->startOfMonth();
        $currentDate = now()->startOfMonth();

        $totalMonths = $startDate->diffInMonths($currentDate) + 1;

        for ($i = 0; $i < $totalMonths; $i++) {
            $date = $currentDate->copy()->subMonths($i);

            $months[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ];
        }

        return $months;
    }
    public function downloadInvoice()
    {
        if (!$this->selectedMonth) {
            abort(400, 'Month not selected');
        }

        [$year, $month] = explode('-', $this->selectedMonth);

        $orders = $this->service->getOrdersByMonthForSeller(
            sellerId: user()->id,
            month: (int) $month,
            year: (int) $year
        );

        // ✅ CSV
        if ($this->fileType === 'csv') {
            return response()->streamDownload(function () use ($orders) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Order ID',
                    'Product',
                    'Buyer',
                    'Quantity',
                    'Amount',
                    'Status',
                    'Date',
                ]);

                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->order_id,
                        $order->source->name ?? '',
                        $order->user->full_name ?? '',
                        $order->total_quantity,
                        $order->total_amount,
                        $order->status->label(),
                        $order->created_at->format('Y-m-d'),
                    ]);
                }

                fclose($handle);
            }, "sales-invoice-{$year}-{$month}.csv");
        }

        // ✅ PDF
        if ($this->fileType === 'pdf') {
            $pdf = Pdf::loadView('pdf-template.invoice', [
                'orders' => $orders,
                'month'  => $month,
                'year'   => $year,
                'seller' => user(),
            ]);

            return response()->streamDownload(
                fn() => print($pdf->output()),
                "sales-invoice-{$year}-{$month}.pdf"
            );
        }

        abort(400, 'Invalid file type');
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? null,
            'status' => $this->status ?? null,
            'created_at' => $this->created_at ?? null,
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'seller_id' => user()->id,
        ];
    }
}
