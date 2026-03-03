<?php

namespace App\Livewire\Backend\Admin;

use App\Services\DashboardService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Dashboard extends Component
{
    use WithNotification;

    public string $filter = 'current_week';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public array $stats                     = [];
    public array $financialFlowData         = [];
    public array $orderLifecycleData        = [];
    public array $revenueByGameData         = [];
    public array $revenueByGameCategoryData = [];
    public array $profitCommissionData      = [];
    public array $withdrawalQueueData       = [];
    public array $sellerEngagementData      = [];
    public array $topSellersData            = [];
    public array $escrowHealthData          = [];
    public array $buyerActivityData         = [];
    public array $disputeRefundData         = [];

    public bool $isEmpty = false;

    protected DashboardService $service;

    public function boot(DashboardService $service): void
    {
        $this->service = $service;
    }

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
        $this->filter    = 'current_week';
        $this->startDate = null;
        $this->endDate   = null;
        $this->loadDashboardData();
        $this->dispatchChartUpdate();
    }

    public function render()
    {
        return view('livewire.backend.admin.dashboard');
    }

    /* ================================================================
     *  PRIVATE
     * ================================================================ */

    private function loadDashboardData(): void
    {
        [$start, $end]         = $this->service->getDateRange($this->filter, $this->startDate, $this->endDate);
        [$prevStart, $prevEnd] = $this->service->getPreviousDateRange($start, $end);

        $this->stats                     = $this->service->computeStats($start, $end, $prevStart, $prevEnd);
        $this->financialFlowData         = $this->service->computeFinancialFlowData($start, $end, $this->filter);
        $this->orderLifecycleData        = $this->service->computeOrderLifecycleData($start, $end);
        $this->revenueByGameData         = $this->service->computeRevenueByGameData($start, $end);
        $this->revenueByGameCategoryData = $this->service->computeRevenueByGameCategoryData($start, $end);
        $this->profitCommissionData      = $this->service->computeProfitCommissionData($start, $end, $this->filter);
        $this->withdrawalQueueData       = $this->service->computeWithdrawalQueueData($start, $end);
        $this->sellerEngagementData      = $this->service->computeSellerEngagementData($start, $end, $this->filter);
        $this->topSellersData            = $this->service->computeTopSellersData($start, $end);
        $this->escrowHealthData          = $this->service->computeEscrowHealthData($start, $end, $this->filter);
        $this->buyerActivityData         = $this->service->computeBuyerActivityData($start, $end, $this->filter);
        $this->disputeRefundData         = $this->service->computeDisputeRefundData($start, $end, $this->filter);

        $this->isEmpty = ($this->stats['total_orders'] ?? 0) === 0
            && ($this->stats['total_users'] ?? 0) === 0;
    }

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
            topSellers: $this->topSellersData,
            escrowHealth: $this->escrowHealthData,
            buyerActivity: $this->buyerActivityData,
            disputeRefund: $this->disputeRefundData,
        );
    }
}
