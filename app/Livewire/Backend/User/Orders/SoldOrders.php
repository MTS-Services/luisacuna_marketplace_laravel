<?php

namespace App\Livewire\Backend\User\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\OrderStateMachine;
use App\Traits\Livewire\WithNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class SoldOrders extends Component
{
    use WithNotification;

    public $perPage = 10;

    public $pagination = [];

    public $status;

    public $order_date;

    public $search;

    protected OrderService $service;

    protected OrderStateMachine $stateMachine;

    public function boot(OrderService $service, OrderStateMachine $stateMachine): void
    {
        $this->service = $service;
        $this->stateMachine = $stateMachine;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters(),
        );

        $this->pagination = [
            'current_page' => $datas->currentPage(),
            'last_page' => $datas->lastPage(),
            'per_page' => $datas->perPage(),
            'total' => $datas->total(),
            'from' => $datas->firstItem(),
            'to' => $datas->lastItem(),
        ];

        $columns = [
            [
                'key' => 'id',
                'label' => 'Order Name',
                'format' => fn ($order) => '
                <div class="flex items-center gap-3">
                    <div class="w-15 h-15 rounded-lg shrink-0">
                        <img src="'.storage_url($order?->source?->game?->logo).'"'
                    .'alt="'.$order->source->name.'"'
                    .'class="w-full h-full rounded-lg object-cover" />
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    .$order->source->translatedName(app()->getLocale()).
                    '</h3>
                        <p class="text-xs text-text-primary/80 truncate xxs:block py-1">'
                    .'#'.$order->order_id.
                    '</p>
                    </div>
                </div>
        ',
            ],
            [
                'key' => 'user_id',
                'label' => 'Buyer',
                'format' => fn ($order) => '<a href="'.route('profile', ['username' => $order->user->username]).'"><span class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">'.$order->user->full_name.'</span></a>',
            ],
            [
                'key' => 'created_at',
                'label' => 'Ordered date',
                'format' => function ($data) {
                    return $data->created_at_formatted;
                },
            ],
            [
                'key' => 'status',
                'label' => 'Order status',
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge '.$data->status->color().'">'.
                        $data->status->label().
                        '</span>';
                },
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'format' => fn ($order) => $order?->quantity,
            ],
            [
                'key' => 'grand_total',
                'label' => 'Price',
                'format' => fn ($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">'.currency_symbol().currency_exchange($order->total_amount).'</span>',
            ],
        ];

        // ($order->status->value === 'cancelled'
        //                 ? route('user.order.cancel', ['orderId' => $order->order_id])
        //                 : route('user.order.complete', ['orderId' => $order->order_id])

        $actions = [
            [
                'param' => 'order_id',
                'label' => 'View Details',
                'route' => 'user.order.complete',
                'icon' => 'eye',
                'hoverClass' => 'text-blue-400',
                'encrypt' => true,
                'condition' => fn ($order) => in_array($order->status, [
                    OrderStatus::PAID,
                    OrderStatus::PROCESSING,
                    OrderStatus::CANCEL_REQ_BY_SELLER,
                    OrderStatus::CANCEL_REQ_BY_BUYER,
                    OrderStatus::DELIVERED,
                    OrderStatus::DISPUTED,
                    OrderStatus::ESCALATED,
                    OrderStatus::COMPLETED,
                    OrderStatus::RESOLVED,
                    OrderStatus::REFUNDED,
                    OrderStatus::PENDING_PAYMENT,
                    OrderStatus::PARTIALLY_PAID,
                    OrderStatus::PARTIALLY_REFUNDED,
                    OrderStatus::CANCELLED_BY_SELLER,
                    OrderStatus::CANCELLED_BY_BUYER,
                    OrderStatus::CANCELLED_BY_ADMIN,
                ]),
            ],
            [
                'param' => 'order_id',
                'label' => 'View Details',
                'route' => 'user.order.cancel',
                'icon' => 'eye',
                'hoverClass' => 'text-red-400',
                'encrypt' => true,
                'condition' => fn ($order) => in_array($order->status, [
                    OrderStatus::CANCELLED,
                    OrderStatus::FAILED,
                ]),
            ],
            [
                'param' => 'id',
                'label' => 'Mark as Delivered',
                'method' => 'markDelivered',
                'icon' => 'truck',
                'hoverClass' => 'text-green-400',
                'encrypt' => true,
                'condition' => fn ($order) => in_array($order->status, [
                    OrderStatus::PAID,
                    OrderStatus::DISPUTED,
                ]),
            ],
            [
                'param' => 'id',
                'label' => 'Cancel Order',
                'method' => 'cancelOrder',
                'icon' => 'prohibit',
                'hoverClass' => 'text-red-400',
                'encrypt' => true,
                'condition' => fn ($order) => in_array($order->status, [
                    OrderStatus::PAID,
                    OrderStatus::DELIVERED,
                    OrderStatus::DISPUTED,
                    OrderStatus::ESCALATED,
                ]),
            ],
            [
                'param' => 'id',
                'label' => 'Accept Cancel',
                'method' => 'acceptCancel',
                'icon' => 'check-circle',
                'hoverClass' => 'text-green-400',
                'encrypt' => true,
                'condition' => fn ($order) => $order->status === OrderStatus::CANCEL_REQ_BY_BUYER,
            ],
            [
                'param' => 'id',
                'label' => 'Reject Cancel',
                'method' => 'rejectCancel',
                'icon' => 'x-circle',
                'hoverClass' => 'text-red-400',
                'encrypt' => true,
                'condition' => fn ($order) => $order->status === OrderStatus::CANCEL_REQ_BY_BUYER,
            ],
            [
                'param' => 'id',
                'label' => 'Escalate to Support',
                'method' => 'escalateToSupport',
                'icon' => 'megaphone-simple',
                'hoverClass' => 'text-yellow-400',
                'encrypt' => true,
                'condition' => fn ($order) => ! $order->status->isTerminal()
                    && (
                        in_array($order->status, [
                            OrderStatus::DISPUTED,
                            OrderStatus::CANCEL_REQ_BY_SELLER,
                            OrderStatus::CANCEL_REQ_BY_BUYER,
                        ])
                        || (
                            (($order->delivery_attempts ?? 0) >= 3 || ($order->cancel_attempts ?? 0) >= 3)
                            && $order->status !== OrderStatus::ESCALATED
                        )
                    ),
            ],
        ];

        return view('livewire.backend.user.orders.sold-orders', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'statuses' => [
                ['label' => 'Processing', 'value' => OrderStatus::PAID->value],

                ['label' => 'Cancel Requested by Buyer', 'value' => OrderStatus::CANCEL_REQ_BY_BUYER->value],
                ['label' => 'Cancel Requested by Seller', 'value' => OrderStatus::CANCEL_REQ_BY_SELLER->value],
                ['label' => 'Delivered', 'value' => OrderStatus::DELIVERED->value],
                ['label' => 'Disputed', 'value' => OrderStatus::DISPUTED->value],
                ['label' => 'Escalated', 'value' => OrderStatus::ESCALATED->value],
                ['label' => 'Completed', 'value' => OrderStatus::COMPLETED->value],
                ['label' => 'Resolved', 'value' => OrderStatus::RESOLVED->value],
                ['label' => 'Cancelled', 'value' => OrderStatus::CANCELLED->value],
                ['label' => 'Refunded', 'value' => OrderStatus::REFUNDED->value],
            ],
        ]);
    }

    public function markDelivered($encryptedId): void
    {
        $id = decrypt($encryptedId);

        // $order = Order::find($id);
        // if ($order && ($order->delivery_attempts ?? 0) >= 3) {
        //     $this->error(__('Maximum delivery attempts reached. This order has been escalated to support.'));
        //     $this->executeTransition($id, OrderStatus::ESCALATED);

        //     return;
        // }

        $this->executeTransition($id, OrderStatus::DELIVERED);
    }

    public function acceptCancel($encryptedId): void
    {
        $this->executeTransition(decrypt($encryptedId), OrderStatus::CANCELLED);
    }

    public function rejectCancel($encryptedId): void
    {
        $this->executeTransition(decrypt($encryptedId), OrderStatus::PAID);
    }

    public function cancelOrder($encryptedId): void
    {
        $this->executeTransition(decrypt($encryptedId), OrderStatus::CANCEL_REQ_BY_SELLER);
    }

    public function escalateToSupport($encryptedId): void
    {
        $this->executeTransition(decrypt($encryptedId), OrderStatus::ESCALATED);
    }

    protected function executeTransition($id, OrderStatus $targetStatus): void
    {
        try {
            $order = Order::findOrFail($id);
            if ((int) ($order->source?->user_id ?? 0) !== (int) user()->id) {
                $this->error(__('Unauthorized action.'));

                return;
            }

            $this->stateMachine->transition(
                order: $order,
                targetStatus: $targetStatus,
                actor: user(),
            );

            $this->success(__('Order updated successfully.'));
        } catch (Throwable $e) {
            Log::error('Error executing transition', [
                'order_id' => $id,
                'target_status' => $targetStatus,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error('Something went wrong. Please try again.');
        }
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? null,
            'status' => $this->status ?? null,
            'order_date' => $this->order_date ?? null,
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'seller_id' => user()->id,
            'exclude_status' => [OrderStatus::INITIALIZED, OrderStatus::PENDING],

        ];
    }

    public function downloadInvoice()
    {
        $orders = $this->service->getAllOrdersForSeller(
            $this->getFilters()
        );

        if ($orders->isEmpty()) {
            session()->flash('error', __('No data found to download.'));

            return;
        }
        $invoiceId = 'INV-'.strtoupper(uniqid());
        $pdf = Pdf::loadView('pdf-template.invoice', [
            'orders' => $orders,
            'seller' => Auth::user(),
            'date' => now()->format('d M Y'),
            'invoiceId' => $invoiceId,
        ]);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'sold-orders-invoice-'.now()->format('Y-m-d').'.pdf'
        );
    }
}
