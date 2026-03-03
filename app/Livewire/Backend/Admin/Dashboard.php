<?php

namespace App\Livewire\Backend\Admin;

use App\Enums\OrderStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\UserType;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\Livewire\WithNotification;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    use WithNotification;

    public string $filter = 'current_week';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public array $stats = [];

    public array $financialFlowData = [];

    public array $orderLifecycleData = [];

    public array $revenueByGameData = [];

    public array $revenueByGameCategoryData = [];

    public array $profitCommissionData = [];

    public array $withdrawalQueueData = [];

    public array $sellerEngagementData = [];

    public bool $isEmpty = false;

    public function mount(): void
    {
        $this->loadDashboardData();
    }

    public function updatedFilter(): void
    {
        if ($this->filter === 'custom_range' && (! $this->startDate || ! $this->endDate)) {
            return;
        }

        $this->loadDashboardData();
        $this->dispatchChartUpdate();
    }

    public function updatedStartDate(): void
    {
        if ($this->filter === 'custom_range' && $this->startDate && $this->endDate) {
            $this->loadDashboardData();
            $this->dispatchChartUpdate();
        }
    }

    public function updatedEndDate(): void
    {
        if ($this->filter === 'custom_range' && $this->startDate && $this->endDate) {
            $this->loadDashboardData();
            $this->dispatchChartUpdate();
        }
    }

    public function refreshData(): void
    {
        $this->loadDashboardData();
        $this->dispatchChartUpdate();
    }

    public function resetFilter(): void
    {
        $this->filter = 'current_week';
        $this->startDate = null;
        $this->endDate = null;
        $this->loadDashboardData();
        $this->dispatchChartUpdate();
    }

    public function render()
    {
        return view('livewire.backend.admin.dashboard');
    }

    /* ================================================================
     *  PRIVATE HELPERS
     * ================================================================ */

    private function dispatchChartUpdate(): void
    {
        $this->dispatch(
            'charts-updated',
            financialFlow: $this->financialFlowData,
            orderLifecycle: $this->orderLifecycleData,
            revenueByGame: $this->revenueByGameData,
            revenueByGameCategory: $this->revenueByGameCategoryData,
            profitCommission: $this->profitCommissionData,
            withdrawalQueue: $this->withdrawalQueueData,
            sellerEngagement: $this->sellerEngagementData,
        );
    }

    private function loadDashboardData(): void
    {
        [$start, $end] = $this->getDateRange();
        [$prevStart, $prevEnd] = $this->getPreviousDateRange($start, $end);

        $this->stats = $this->computeStats($start, $end, $prevStart, $prevEnd);
        $this->financialFlowData = $this->computeFinancialFlowData($start, $end);
        $this->orderLifecycleData = $this->computeOrderLifecycleData($start, $end);
        $this->revenueByGameData = $this->computeRevenueByGameData($start, $end);
        $this->revenueByGameCategoryData = $this->computeRevenueByGameCategoryData($start, $end);
        $this->profitCommissionData = $this->computeProfitCommissionData($start, $end);
        $this->withdrawalQueueData = $this->computeWithdrawalQueueData($start, $end);
        $this->sellerEngagementData = $this->computeSellerEngagementData($start, $end);

        $this->isEmpty = ($this->stats['total_orders'] ?? 0) === 0
            && ($this->stats['total_users'] ?? 0) === 0;
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function getDateRange(): array
    {
        return match ($this->filter) {
            'real_time' => [now()->subHours(24), now()],
            'current_week' => [now()->startOfWeek(), now()->endOfWeek()],
            'current_month' => [now()->startOfMonth(), now()->endOfMonth()],
            'current_year' => [now()->startOfYear(), now()->endOfYear()],
            'custom_range' => [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ],
            default => [now()->startOfWeek(), now()->endOfWeek()],
        };
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function getPreviousDateRange(Carbon $start, Carbon $end): array
    {
        $diff = $start->diffInSeconds($end);

        return [
            $start->copy()->subSeconds((int) $diff),
            $start->copy(),
        ];
    }

    private function getGroupFormat(): string
    {
        return match ($this->filter) {
            'real_time' => '%Y-%m-%d %H:00',
            'current_year' => '%Y-%m',
            default => '%Y-%m-%d',
        };
    }

    private function getPeriodKey(Carbon $period): string
    {
        return match ($this->filter) {
            'real_time' => $period->format('Y-m-d H:00'),
            'current_year' => $period->format('Y-m'),
            default => $period->format('Y-m-d'),
        };
    }

    private function getPeriodLabel(Carbon $period): string
    {
        return match ($this->filter) {
            'real_time' => $period->format('H:i'),
            'current_year' => $period->format('M'),
            default => $period->format('M d'),
        };
    }

    /**
     * @return Carbon[]
     */
    private function generatePeriods(Carbon $start, Carbon $end): array
    {
        $interval = match ($this->filter) {
            'real_time' => '1 hour',
            'current_year' => '1 month',
            default => '1 day',
        };

        return CarbonPeriod::create($start, $interval, $end)->toArray();
    }

    /**
     * @return string[]
     */
    private function revenueStatuses(): array
    {
        return [
            OrderStatus::COMPLETED->value,
            OrderStatus::DELIVERED->value,
            OrderStatus::PAID->value,
            OrderStatus::PROCESSING->value,
        ];
    }

    private function computeGrowth(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /* ================================================================
     *  STAT CARDS
     * ================================================================ */

    private function computeStats(Carbon $start, Carbon $end, Carbon $prevStart, Carbon $prevEnd): array
    {
        $revenueStatuses = $this->revenueStatuses();

        $currentUsers = User::query()->whereBetween('created_at', [$start, $end])->count();
        $currentOrders = Order::query()->whereBetween('created_at', [$start, $end])->count();
        $currentRevenue = (float) Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', $revenueStatuses)
            ->sum('default_grand_total');
        $currentSellers = User::query()
            ->whereIn('user_type', [UserType::SELLER->value, UserType::BOTH->value])
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $prevUsers = User::query()->whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevOrders = Order::query()->whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevRevenue = (float) Order::query()
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->whereIn('status', $revenueStatuses)
            ->sum('default_grand_total');
        $prevSellers = User::query()
            ->whereIn('user_type', [UserType::SELLER->value, UserType::BOTH->value])
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        return [
            'total_users' => $currentUsers,
            'users_growth' => $this->computeGrowth($currentUsers, $prevUsers),
            'total_orders' => $currentOrders,
            'orders_growth' => $this->computeGrowth($currentOrders, $prevOrders),
            'total_revenue' => $currentRevenue,
            'revenue_growth' => $this->computeGrowth((int) $currentRevenue, (int) $prevRevenue),
            'total_sellers' => $currentSellers,
            'sellers_growth' => $this->computeGrowth($currentSellers, $prevSellers),
        ];
    }

    /* ================================================================
     *  CHART 1: Financial Flow (Area) — Payments In vs Withdrawals Out
     * ================================================================ */

    private function computeFinancialFlowData(Carbon $start, Carbon $end): array
    {
        $groupFormat = $this->getGroupFormat();

        $payments = DB::table('payments')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(default_amount, 0)) as total_in')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $withdrawals = DB::table('withdrawal_requests')
            ->whereIn('id', function ($q) {
                $q->select('withdrawal_request_id')
                    ->from('withdrawal_status_histories')
                    ->where('to_status', 'completed')
                    ->whereNull('deleted_at');
            })
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(final_amount, 0)) as total_out')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $labels = [];
        $paymentsIn = [];
        $payoutsOut = [];

        foreach ($this->generatePeriods($start, $end) as $period) {
            $key = $this->getPeriodKey($period);
            $labels[] = $this->getPeriodLabel($period);
            $paymentsIn[] = round((float) ($payments->get($key)?->total_in ?? 0), 2);
            $payoutsOut[] = round((float) ($withdrawals->get($key)?->total_out ?? 0), 2);
        }

        return [
            'labels' => $labels,
            'series' => [
                ['name' => __('Payments Received'), 'data' => $paymentsIn],
                ['name' => __('Seller Payouts'), 'data' => $payoutsOut],
            ],
        ];
    }

    /* ================================================================
     *  CHART 2: Order Lifecycle (Donut) — Escrowed / Delivered / Cancelled
     * ================================================================ */

    private function computeOrderLifecycleData(Carbon $start, Carbon $end): array
    {
        $escrowedStatuses = [
            OrderStatus::PAID->value,
            OrderStatus::PROCESSING->value,
            OrderStatus::PENDING_PAYMENT->value,
            OrderStatus::PARTIALLY_PAID->value,
        ];

        $deliveredStatuses = [
            OrderStatus::DELIVERED->value,
            OrderStatus::COMPLETED->value,
        ];

        $cancelledStatuses = [
            OrderStatus::CANCELLED->value,
            OrderStatus::REFUNDED->value,
            OrderStatus::PARTIALLY_REFUNDED->value,
            OrderStatus::FAILED->value,
        ];

        $counts = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->whereNotIn('status', [OrderStatus::INITIALIZED->value, OrderStatus::PENDING->value])
            ->selectRaw('
                SUM(CASE WHEN status IN (' . $this->buildPlaceholders($escrowedStatuses) . ') THEN 1 ELSE 0 END) as escrowed,
                SUM(CASE WHEN status IN (' . $this->buildPlaceholders($deliveredStatuses) . ') THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status IN (' . $this->buildPlaceholders($cancelledStatuses) . ') THEN 1 ELSE 0 END) as cancelled
            ', [...$escrowedStatuses, ...$deliveredStatuses, ...$cancelledStatuses])
            ->first();

        return [
            'labels' => [__('Escrowed'), __('Delivered'), __('Cancelled')],
            'series' => [
                (int) ($counts?->escrowed ?? 0),
                (int) ($counts?->delivered ?? 0),
                (int) ($counts?->cancelled ?? 0),
            ],
        ];
    }

    /* ================================================================
     *  CHART 3: Revenue by Game (Horizontal Bar)
     * ================================================================ */

    private function computeRevenueByGameData(Carbon $start, Carbon $end): array
    {
        $revenueStatuses = $this->revenueStatuses();

        $gameRevenue = DB::table('orders')
            ->join('products', function ($join) {
                $join->on('orders.source_id', '=', 'products.id')
                    ->where('orders.source_type', Product::class);
            })
            ->join('games', 'products.game_id', '=', 'games.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', $revenueStatuses)
            ->whereNull('orders.deleted_at')
            ->whereNull('games.deleted_at')
            ->selectRaw('games.name as game_name, SUM(COALESCE(orders.default_grand_total, 0)) as revenue')
            ->groupBy('games.id', 'games.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return [
            'labels' => $gameRevenue->pluck('game_name')->toArray(),
            'series' => $gameRevenue->pluck('revenue')->map(fn($v) => round((float) $v, 2))->toArray(),
        ];
    }

    /* ================================================================
     *  CHART 4: Revenue by Game Category (Horizontal Bar)
     * ================================================================ */

    private function computeRevenueByGameCategoryData(Carbon $start, Carbon $end): array
    {
        $revenueStatuses = $this->revenueStatuses();

        $categoryRevenue = DB::table('orders')
            ->join('products', function ($join) {
                $join->on('orders.source_id', '=', 'products.id')
                    ->where('orders.source_type', Product::class);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', $revenueStatuses)
            ->whereNull('orders.deleted_at')
            ->whereNull('categories.deleted_at')
            ->selectRaw('categories.name as category_name, SUM(COALESCE(orders.default_grand_total, 0)) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return [
            'labels' => $categoryRevenue->pluck('category_name')->toArray(),
            'series' => $categoryRevenue->pluck('revenue')->map(fn($v) => round((float) $v, 2))->toArray(),
        ];
    }

    /* ================================================================
     *  CHART 5: Profit & Commission (Grouped Column)
     * ================================================================ */

    private function computeProfitCommissionData(Carbon $start, Carbon $end): array
    {
        $groupFormat = $this->getGroupFormat();

        $transactions = DB::table('transactions')
            ->where('type', TransactionType::SALES->value)
            ->where('status', TransactionStatus::PAID->value)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(amount, 0)) as sales_volume')
            ->selectRaw('SUM(COALESCE(fee_amount, 0)) as platform_profit')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $labels = [];
        $salesVolume = [];
        $platformProfit = [];

        foreach ($this->generatePeriods($start, $end) as $period) {
            $key = $this->getPeriodKey($period);
            $labels[] = $this->getPeriodLabel($period);

            $row = $transactions->get($key);
            $salesVolume[] = round((float) ($row?->sales_volume ?? 0), 2);
            $platformProfit[] = round((float) ($row?->platform_profit ?? 0), 2);
        }

        return [
            'labels' => $labels,
            'series' => [
                ['name' => __('Sales Volume'), 'data' => $salesVolume],
                ['name' => __('Platform Profit'), 'data' => $platformProfit],
            ],
        ];
    }

    /* ================================================================
     *  CHART 6: Withdrawal Queue (Stacked Bar)
     * ================================================================ */

    private function computeWithdrawalQueueData(Carbon $start, Carbon $end): array
    {
        $statusCounts = DB::table('withdrawal_requests')
            ->join(
                DB::raw('(
                    SELECT wsh1.withdrawal_request_id, wsh1.to_status
                    FROM withdrawal_status_histories wsh1
                    INNER JOIN (
                        SELECT withdrawal_request_id, MAX(id) as max_id
                        FROM withdrawal_status_histories
                        WHERE deleted_at IS NULL
                        GROUP BY withdrawal_request_id
                    ) wsh2 ON wsh1.id = wsh2.max_id
                ) as latest_status'),
                'withdrawal_requests.id',
                '=',
                'latest_status.withdrawal_request_id'
            )
            ->whereBetween('withdrawal_requests.created_at', [$start, $end])
            ->whereNull('withdrawal_requests.deleted_at')
            ->selectRaw("
                SUM(CASE WHEN latest_status.to_status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN latest_status.to_status = 'accepted' THEN 1 ELSE 0 END) as accepted_count,
                SUM(CASE WHEN latest_status.to_status = 'completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN latest_status.to_status IN ('rejected', 'canceled') THEN 1 ELSE 0 END) as rejected_count
            ")
            ->first();

        return [
            'labels' => [__('Pending'), __('Accepted'), __('Completed'), __('Rejected')],
            'series' => [
                (int) ($statusCounts?->pending_count ?? 0),
                (int) ($statusCounts?->accepted_count ?? 0),
                (int) ($statusCounts?->completed_count ?? 0),
                (int) ($statusCounts?->rejected_count ?? 0),
            ],
            'colors' => ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
        ];
    }

    /* ================================================================
     *  CHART 7: Seller Engagement (Line) — New Listings vs Sign-ups
     * ================================================================ */

    private function computeSellerEngagementData(Carbon $start, Carbon $end): array
    {
        $groupFormat = $this->getGroupFormat();

        $listings = DB::table('products')
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->selectRaw('DATE_FORMAT(created_at, ?) as period, COUNT(*) as listing_count', [$groupFormat])
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $sellerSignups = DB::table('users')
            ->whereIn('user_type', [UserType::SELLER->value, UserType::BOTH->value])
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->selectRaw('DATE_FORMAT(created_at, ?) as period, COUNT(*) as signup_count', [$groupFormat])
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $labels = [];
        $listingCounts = [];
        $signupCounts = [];

        foreach ($this->generatePeriods($start, $end) as $period) {
            $key = $this->getPeriodKey($period);
            $labels[] = $this->getPeriodLabel($period);
            $listingCounts[] = (int) ($listings->get($key)?->listing_count ?? 0);
            $signupCounts[] = (int) ($sellerSignups->get($key)?->signup_count ?? 0);
        }

        return [
            'labels' => $labels,
            'series' => [
                ['name' => __('New Listings'), 'data' => $listingCounts],
                ['name' => __('New Sellers'), 'data' => $signupCounts],
            ],
        ];
    }

    /* ================================================================
     *  QUERY UTILITY
     * ================================================================ */

    /**
     * @param  string[]  $values
     */
    private function buildPlaceholders(array $values): string
    {
        return implode(',', array_fill(0, count($values), '?'));
    }
}
