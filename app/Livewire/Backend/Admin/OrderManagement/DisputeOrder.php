<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\Url;
use Livewire\Component;

class DisputeOrder extends Component
{
    use WithDataTable, WithNotification;

    #[Url(keep: true)]
    public string $tab = 'open';

    public $statusFilter = '';

    public $showDeleteModal = false;

    public $deleteCategoryId = null;

    public $bulkAction = '';

    public $showBulkActionModal = false;

    public $deleteId = null;

    protected OrderService $service;

    public function boot(OrderService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->tab = request()->input('tab', 'open');
    }

    public function render()
    {
        $query = Order::query()
            ->with(['source.user', 'user', 'source.game', 'dispute'])
            ->when($this->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('order_id', 'like', "%{$search}%")
                        ->orWhereHas('user', fn($q) => $q->where('username', 'like', "%{$search}%"))
                        ->orWhereHasMorph('source', ['App\Models\Product'], fn($q) => $q->where('name', 'like', "%{$search}%"));
                });
            });

        $query = match ($this->tab) {
            'open' => $query->whereIn('status', [
                OrderStatus::DISPUTED->value,
                OrderStatus::ESCALATED->value,
            ]),
            'resolved' => $query->where('status', OrderStatus::RESOLVED->value),
            'closed' => $query->whereIn('status', [
                OrderStatus::CANCELLED->value,
                OrderStatus::COMPLETED->value,
            ])->where('is_disputed', true),
            default => $query->whereIn('status', [
                OrderStatus::DISPUTED->value,
                OrderStatus::ESCALATED->value,
            ]),
        };

        $datas = $query
            ->orderBy($this->sortField ?? 'created_at', $this->sortDirection ?? 'desc')
            ->paginate($this->perPage);

        $openCount = Order::query()->whereIn('status', [
            OrderStatus::DISPUTED->value,
            OrderStatus::ESCALATED->value,
        ])->count();

        $resolvedCount = Order::query()->where('status', OrderStatus::RESOLVED->value)->count();

        $closedCount = Order::query()->whereIn('status', [
            OrderStatus::CANCELLED->value,
            OrderStatus::COMPLETED->value,
        ])->where('is_disputed', true)->count();

        $columns = [
            [
                'key' => 'order_id',
                'label' => 'Order ID',
                'sortable' => true,
            ],
            [
                'key' => 'source_id',
                'label' => 'Product Title',
                'format' => fn($order) => '
                <div class="flex items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-text-white text-xs xxs:text-sm md:text-base truncate">'
                    . e($order->source?->name ?? '—') .
                    '</h3>
                    </div>
                </div>',
            ],
            [
                'key' => 'user_id',
                'label' => 'Buyer',
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->user?->username]) . '"><span class="text-text-white text-xs xxs:text-sm md:text-base truncate">' . e($order->user?->full_name ?? '—') . '</span></a>',
            ],
            [
                'key' => 'source_id',
                'label' => 'Seller',
                'format' => fn($order) => '<a href="' . route('profile', ['username' => $order->source?->user?->username]) . '"><span class="text-text-white text-xs xxs:text-sm md:text-base truncate">' . e($order->source?->user?->full_name ?? '—') . '</span></a>',
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => fn($order) => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge ' . $order->status->color() . '">' . $order->status->label() . '</span>',
            ],
            [
                'key' => 'total_amount',
                'label' => 'Price',
                'sortable' => true,
                'format' => fn($order) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' . currency_symbol() . $order->total_amount . '</span>',
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($order) {
                    return $order->created_at_formatted;
                },
            ],
        ];

        $actions = [
            [
                'key' => 'order_id',
                'label' => 'View',
                'route' => 'admin.orders.dispute-show',
            ],
            [
                'key' => 'order_id',
                'label' => 'Deep View',
                'route' => 'admin.orders.deep-view',
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
        ];

        return view('livewire.backend.admin.order-management.dispute-order', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
            'openCount' => $openCount,
            'resolvedCount' => $resolvedCount,
            'closedCount' => $closedCount,
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
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
            'is_dispute' => true,
        ];
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
