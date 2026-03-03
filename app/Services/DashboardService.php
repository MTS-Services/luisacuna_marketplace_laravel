<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\UserType;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /* ================================================================
     *  DATE / PERIOD HELPERS
     * ================================================================ */

    public function getDateRange(string $filter, ?string $startDate, ?string $endDate): array
    {
        return match ($filter) {
            'real_time'     => [now()->subDays(6)->startOfDay(), now()],
            'current_week'  => [now()->startOfWeek(), now()->endOfWeek()],
            'current_month' => [now()->startOfMonth(), now()->endOfMonth()],
            'current_year'  => [now()->startOfYear(), now()->endOfYear()],
            'custom_range'  => [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ],
            default => [now()->startOfWeek(), now()->endOfWeek()],
        };
    }

    public function getPreviousDateRange(Carbon $start, Carbon $end): array
    {
        $diff = $start->diffInSeconds($end);

        return [
            $start->copy()->subSeconds((int) $diff),
            $start->copy(),
        ];
    }

    public function getGroupFormat(string $filter): string
    {
        return match ($filter) {
            'current_year' => '%Y-%m',
            default        => '%Y-%m-%d',
        };
    }

    public function getPeriodKey(Carbon $period, string $filter): string
    {
        return match ($filter) {
            'current_year' => $period->format('Y-m'),
            default        => $period->format('Y-m-d'),
        };
    }

    public function getPeriodLabel(Carbon $period, string $filter): string
    {
        return match ($filter) {
            'current_year' => $period->format('M'),
            default        => $period->format('M d'),
        };
    }

    public function generatePeriods(Carbon $start, Carbon $end, string $filter): array
    {
        $interval = match ($filter) {
            'current_year' => '1 month',
            default        => '1 day',
        };

        return CarbonPeriod::create($start, $interval, $end)->toArray();
    }

    public function revenueStatuses(): array
    {
        return [
            OrderStatus::COMPLETED->value,
            OrderStatus::DELIVERED->value,
            OrderStatus::PAID->value,
            OrderStatus::PROCESSING->value,
        ];
    }

    public function computeGrowth(float $current, float $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /* ================================================================
     *  STAT CARDS
     * ================================================================ */

    public function computeStats(
        Carbon $start,
        Carbon $end,
        Carbon $prevStart,
        Carbon $prevEnd
    ): array {
        $revenueStatuses = $this->revenueStatuses();

        // Current period
        $currentUsers   = User::whereBetween('created_at', [$start, $end])->count();
        $currentOrders  = Order::whereBetween('created_at', [$start, $end])->count();
        $currentRevenue = (float) Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status', $revenueStatuses)
            ->sum('default_grand_total');
        $currentSellers = User::whereIn('user_type', [UserType::SELLER->value, UserType::BOTH->value])
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Previous period
        $prevUsers   = User::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevOrders  = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevRevenue = (float) Order::whereBetween('created_at', [$prevStart, $prevEnd])
            ->whereIn('status', $revenueStatuses)
            ->sum('default_grand_total');
        $prevSellers = User::whereIn('user_type', [UserType::SELLER->value, UserType::BOTH->value])
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        // Additional quick stats (all-time or period-agnostic)
        $pendingWithdrawals = DB::table('withdrawal_requests')
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
                ) as ls'),
                'withdrawal_requests.id',
                '=',
                'ls.withdrawal_request_id'
            )
            ->where('ls.to_status', 'pending')
            ->whereNull('withdrawal_requests.deleted_at')
            ->count();

        $activeProducts = Product::whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->count();

        return [
            'total_users'          => $currentUsers,
            'users_growth'         => $this->computeGrowth($currentUsers, $prevUsers),
            'total_orders'         => $currentOrders,
            'orders_growth'        => $this->computeGrowth($currentOrders, $prevOrders),
            'total_revenue'        => $currentRevenue,
            'revenue_growth'       => $this->computeGrowth($currentRevenue, $prevRevenue),
            'total_sellers'        => $currentSellers,
            'sellers_growth'       => $this->computeGrowth($currentSellers, $prevSellers),
            'pending_withdrawals'  => $pendingWithdrawals,
            'active_products'      => $activeProducts,
        ];
    }

    /* ================================================================
     *  CHART 1 — Financial Flow (Area)
     *  BUG FIX: use `transactions` table (type=purchased, status=paid)
     *  instead of `payments.status = 'paid'` which missed Stripe records.
     *  Also query completed withdrawals for the payout side.
     * ================================================================ */

    public function computeFinancialFlowData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

        // ── Payments In: all completed purchase transactions ──────────
        $payments = DB::table('transactions')
            ->where('type', TransactionType::PURCHSED->value)
            ->where('status', TransactionStatus::PAID->value)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(amount, 0)) as total_in')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        // ── Payouts Out: accepted/completed withdrawal requests ───────
        $withdrawals = DB::table('withdrawal_requests')
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
                ) as ls'),
                'withdrawal_requests.id',
                '=',
                'ls.withdrawal_request_id'
            )
            ->whereIn('ls.to_status', ['accepted', 'completed'])
            ->whereBetween('withdrawal_requests.created_at', [$start, $end])
            ->whereNull('withdrawal_requests.deleted_at')
            ->selectRaw('DATE_FORMAT(withdrawal_requests.created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(final_amount, 0)) as total_out')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $labels     = [];
        $paymentsIn = [];
        $payoutsOut = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key          = $this->getPeriodKey($period, $filter);
            $labels[]     = $this->getPeriodLabel($period, $filter);
            $paymentsIn[] = round((float) ($payments->get($key)?->total_in ?? 0), 2);
            $payoutsOut[] = round((float) ($withdrawals->get($key)?->total_out ?? 0), 2);
        }

        $hasData = array_sum($paymentsIn) > 0 || array_sum($payoutsOut) > 0;

        return [
            'labels'  => $labels,
            'hasData' => $hasData,
            'series'  => [
                ['name' => __('Payments In'), 'data' => $paymentsIn],
                ['name' => __('Seller Payouts'), 'data' => $payoutsOut],
            ],
        ];
    }

    /* ================================================================
     *  CHART 2 — Order Lifecycle (Donut)
     * ================================================================ */

    public function computeOrderLifecycleData(Carbon $start, Carbon $end): array
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

        $allStatuses = [...$escrowedStatuses, ...$deliveredStatuses, ...$cancelledStatuses];
        $ph          = fn(array $v) => implode(',', array_fill(0, count($v), '?'));

        $counts = Order::whereBetween('created_at', [$start, $end])
            ->whereNotIn('status', [OrderStatus::INITIALIZED->value, OrderStatus::PENDING->value])
            ->selectRaw('
                SUM(CASE WHEN status IN (' . $ph($escrowedStatuses) . ') THEN 1 ELSE 0 END) as escrowed,
                SUM(CASE WHEN status IN (' . $ph($deliveredStatuses) . ') THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status IN (' . $ph($cancelledStatuses) . ') THEN 1 ELSE 0 END) as cancelled
            ', $allStatuses)
            ->first();

        $series  = [
            (int) ($counts?->escrowed ?? 0),
            (int) ($counts?->delivered ?? 0),
            (int) ($counts?->cancelled ?? 0),
        ];

        return [
            'labels'  => [__('Escrowed'), __('Delivered'), __('Cancelled')],
            'series'  => $series,
            'hasData' => array_sum($series) > 0,
        ];
    }

    /* ================================================================
     *  CHART 3 — Revenue by Game (Horizontal Bar)
     * ================================================================ */

    public function computeRevenueByGameData(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->join('products', function ($j) {
                $j->on('orders.source_id', '=', 'products.id')
                    ->where('orders.source_type', Product::class);
            })
            ->join('games', 'products.game_id', '=', 'games.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', $this->revenueStatuses())
            ->whereNull('orders.deleted_at')
            ->whereNull('games.deleted_at')
            ->selectRaw('games.name as game_name, SUM(COALESCE(orders.default_grand_total, 0)) as revenue')
            ->groupBy('games.id', 'games.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return [
            'labels'  => $rows->pluck('game_name')->toArray(),
            'series'  => $rows->pluck('revenue')->map(fn($v) => round((float) $v, 2))->toArray(),
            'hasData' => $rows->isNotEmpty(),
        ];
    }

    /* ================================================================
     *  CHART 4 — Revenue by Game Category (Horizontal Bar)
     * ================================================================ */

    public function computeRevenueByGameCategoryData(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->join('products', function ($j) {
                $j->on('orders.source_id', '=', 'products.id')
                    ->where('orders.source_type', Product::class);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', $this->revenueStatuses())
            ->whereNull('orders.deleted_at')
            ->whereNull('categories.deleted_at')
            ->selectRaw('categories.name as category_name, SUM(COALESCE(orders.default_grand_total, 0)) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return [
            'labels'  => $rows->pluck('category_name')->toArray(),
            'series'  => $rows->pluck('revenue')->map(fn($v) => round((float) $v, 2))->toArray(),
            'hasData' => $rows->isNotEmpty(),
        ];
    }

    /* ================================================================
     *  CHART 5 — Profit & Commission (Grouped Column)
     *
     *  WHY PURCHASED (not SALES):
     *  When a buyer pays via Stripe/any gateway a `purchased` transaction
     *  is created immediately with the full amount + fee_amount (platform
     *  cut). The `sales` transaction is only created later when the order
     *  is marked completed/delivered — so querying `sales` leaves the
     *  chart empty for in-flight / escrowed orders.
     *  Using `purchased` gives real-time visibility as soon as money hits.
     * ================================================================ */

    public function computeProfitCommissionData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

        $rows = DB::table('transactions')
            ->where('type', TransactionType::PURCHSED->value)   // ← fixed: was SALES
            ->where('status', TransactionStatus::PAID->value)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(amount, 0)) as sales_volume')
            ->selectRaw('SUM(COALESCE(fee_amount, 0)) as platform_profit')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $labels         = [];
        $salesVolume    = [];
        $platformProfit = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key              = $this->getPeriodKey($period, $filter);
            $labels[]         = $this->getPeriodLabel($period, $filter);
            $row              = $rows->get($key);
            $salesVolume[]    = round((float) ($row?->sales_volume ?? 0), 2);
            $platformProfit[] = round((float) ($row?->platform_profit ?? 0), 2);
        }

        $hasData = array_sum($salesVolume) > 0 || array_sum($platformProfit) > 0;

        return [
            'labels'  => $labels,
            'hasData' => $hasData,
            'series'  => [
                ['name' => __('Sales Volume'), 'data' => $salesVolume],
                ['name' => __('Platform Profit'), 'data' => $platformProfit],
            ],
        ];
    }

    /* ================================================================
     *  CHART 6 — Withdrawal Queue (Donut / Status breakdown)
     * ================================================================ */

    public function computeWithdrawalQueueData(Carbon $start, Carbon $end): array
    {
        $counts = DB::table('withdrawal_requests')
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
                ) as ls'),
                'withdrawal_requests.id',
                '=',
                'ls.withdrawal_request_id'
            )
            ->whereBetween('withdrawal_requests.created_at', [$start, $end])
            ->whereNull('withdrawal_requests.deleted_at')
            ->selectRaw("
                SUM(CASE WHEN ls.to_status = 'pending'  THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN ls.to_status = 'accepted' THEN 1 ELSE 0 END) as accepted_count,
                SUM(CASE WHEN ls.to_status = 'completed' THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN ls.to_status IN ('rejected','canceled') THEN 1 ELSE 0 END) as rejected_count
            ")
            ->first();

        $series = [
            (int) ($counts?->pending_count ?? 0),
            (int) ($counts?->accepted_count ?? 0),
            (int) ($counts?->completed_count ?? 0),
            (int) ($counts?->rejected_count ?? 0),
        ];

        return [
            'labels'  => [__('Pending'), __('Accepted'), __('Completed'), __('Rejected')],
            'series'  => $series,
            'hasData' => array_sum($series) > 0,
            'colors'  => ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
        ];
    }

    /* ================================================================
     *  CHART 7 — Seller Engagement (Line)
     * ================================================================ */

    public function computeSellerEngagementData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

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

        $labels        = [];
        $listingCounts = [];
        $signupCounts  = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key             = $this->getPeriodKey($period, $filter);
            $labels[]        = $this->getPeriodLabel($period, $filter);
            $listingCounts[] = (int) ($listings->get($key)?->listing_count ?? 0);
            $signupCounts[]  = (int) ($sellerSignups->get($key)?->signup_count ?? 0);
        }

        $hasData = array_sum($listingCounts) > 0 || array_sum($signupCounts) > 0;

        return [
            'labels'  => $labels,
            'hasData' => $hasData,
            'series'  => [
                ['name' => __('New Listings'), 'data' => $listingCounts],
                ['name' => __('New Sellers'), 'data' => $signupCounts],
            ],
        ];
    }

    /* ================================================================
     *  CHART 8 — Top Sellers by Revenue (Horizontal Bar)
     *  Core multi-vendor metric: which sellers drive the most GMV.
     * ================================================================ */

    public function computeTopSellersData(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->join('products', function ($j) {
                $j->on('orders.source_id', '=', 'products.id')
                    ->where('orders.source_type', Product::class);
            })
            ->join('users', 'products.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', $this->revenueStatuses())
            ->whereNull('orders.deleted_at')
            ->whereNull('users.deleted_at')
            ->selectRaw('users.username as seller_name, SUM(COALESCE(orders.default_grand_total, 0)) as revenue, COUNT(orders.id) as order_count')
            ->groupBy('users.id', 'users.username')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return [
            'labels'      => $rows->pluck('seller_name')->toArray(),
            'series'      => $rows->pluck('revenue')->map(fn($v) => round((float) $v, 2))->toArray(),
            'orderCounts' => $rows->pluck('order_count')->toArray(),
            'hasData'     => $rows->isNotEmpty(),
        ];
    }

    /* ================================================================
     *  CHART 9 — Platform Escrow Health (Stacked Area)
     *  Total payments collected vs total withdrawn over time.
     *  Gap = live escrow / float your platform holds.
     * ================================================================ */

    public function computeEscrowHealthData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

        $incoming = DB::table('transactions')
            ->where('type', TransactionType::PURCHSED->value)
            ->where('status', TransactionStatus::PAID->value)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(amount, 0)) as total')
            ->groupBy('period')->orderBy('period')
            ->get()->keyBy('period');

        $outgoing = DB::table('withdrawal_requests')
            ->join(DB::raw('(
                SELECT wsh1.withdrawal_request_id, wsh1.to_status
                FROM withdrawal_status_histories wsh1
                INNER JOIN (
                    SELECT withdrawal_request_id, MAX(id) as max_id
                    FROM withdrawal_status_histories
                    WHERE deleted_at IS NULL
                    GROUP BY withdrawal_request_id
                ) wsh2 ON wsh1.id = wsh2.max_id
            ) as ls'), 'withdrawal_requests.id', '=', 'ls.withdrawal_request_id')
            ->whereIn('ls.to_status', ['accepted', 'completed'])
            ->whereBetween('withdrawal_requests.created_at', [$start, $end])
            ->whereNull('withdrawal_requests.deleted_at')
            ->selectRaw('DATE_FORMAT(withdrawal_requests.created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(COALESCE(final_amount, 0)) as total')
            ->groupBy('period')->orderBy('period')
            ->get()->keyBy('period');

        $labels = $paymentsIn = $withdrawals = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key           = $this->getPeriodKey($period, $filter);
            $labels[]      = $this->getPeriodLabel($period, $filter);
            $paymentsIn[]  = round((float) ($incoming->get($key)?->total ?? 0), 2);
            $withdrawals[] = round((float) ($outgoing->get($key)?->total ?? 0), 2);
        }

        return [
            'labels'  => $labels,
            'hasData' => array_sum($paymentsIn) > 0 || array_sum($withdrawals) > 0,
            'series'  => [
                ['name' => __('Payments Collected'), 'data' => $paymentsIn],
                ['name' => __('Withdrawn by Sellers'), 'data' => $withdrawals],
            ],
        ];
    }

    /* ================================================================
     *  CHART 10 — Buyer Activity (Line)
     *  New buyers (first order ever) vs returning buyers per period.
     *  Measures growth quality — are new buyers coming back?
     * ================================================================ */

    public function computeBuyerActivityData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

        $allBuyers = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('COUNT(DISTINCT user_id) as buyer_count')
            ->groupBy('period')->orderBy('period')
            ->get()->keyBy('period');

        // New buyer = no prior order before this period
        $newBuyers = DB::table('orders as o')
            ->whereBetween('o.created_at', [$start, $end])
            ->whereNull('o.deleted_at')
            ->whereRaw('NOT EXISTS (
                SELECT 1 FROM orders o2
                WHERE o2.user_id = o.user_id
                  AND o2.created_at < ? AND o2.deleted_at IS NULL
            )', [$start])
            ->selectRaw('DATE_FORMAT(o.created_at, ?) as period', [$groupFormat])
            ->selectRaw('COUNT(DISTINCT o.user_id) as new_count')
            ->groupBy('period')->orderBy('period')
            ->get()->keyBy('period');

        $labels = $newCounts = $returningCounts = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key              = $this->getPeriodKey($period, $filter);
            $labels[]         = $this->getPeriodLabel($period, $filter);
            $all              = (int) ($allBuyers->get($key)?->buyer_count ?? 0);
            $new              = (int) ($newBuyers->get($key)?->new_count ?? 0);
            $newCounts[]      = $new;
            $returningCounts[] = max(0, $all - $new);
        }

        return [
            'labels'  => $labels,
            'hasData' => array_sum($newCounts) > 0 || array_sum($returningCounts) > 0,
            'series'  => [
                ['name' => __('New Buyers'), 'data' => $newCounts],
                ['name' => __('Returning Buyers'), 'data' => $returningCounts],
            ],
        ];
    }

    /* ================================================================
     *  CHART 11 — Dispute & Refund Rate (Line)
     *  Disputed and refunded orders over time.
     *  Rising values = trust / quality issue to investigate.
     * ================================================================ */

    public function computeDisputeRefundData(Carbon $start, Carbon $end, string $filter): array
    {
        $groupFormat = $this->getGroupFormat($filter);

        $data = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->selectRaw('DATE_FORMAT(created_at, ?) as period', [$groupFormat])
            ->selectRaw('SUM(CASE WHEN is_disputed = 1 THEN 1 ELSE 0 END) as disputed')
            ->selectRaw(
                'SUM(CASE WHEN status IN (?,?) THEN 1 ELSE 0 END) as refunded',
                [OrderStatus::REFUNDED->value, OrderStatus::PARTIALLY_REFUNDED->value]
            )
            ->groupBy('period')->orderBy('period')
            ->get()->keyBy('period');

        $labels = $disputed = $refunded = [];

        foreach ($this->generatePeriods($start, $end, $filter) as $period) {
            $key        = $this->getPeriodKey($period, $filter);
            $labels[]   = $this->getPeriodLabel($period, $filter);
            $row        = $data->get($key);
            $disputed[] = (int) ($row?->disputed ?? 0);
            $refunded[] = (int) ($row?->refunded ?? 0);
        }

        return [
            'labels'  => $labels,
            'hasData' => array_sum($disputed) > 0 || array_sum($refunded) > 0,
            'series'  => [
                ['name' => __('Disputed'), 'data' => $disputed],
                ['name' => __('Refunded'), 'data' => $refunded],
            ],
        ];
    }
}
