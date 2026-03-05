<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Profile;

use App\Enums\OrderStatus;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\PointLog;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Livewire\Component;
use Livewire\WithPagination;

class PersonaInfo extends Component
{
    use WithPagination;

    public User $user;

    public string $activeTab = 'personal';

    // ── Buyer Stats ────────────────────────────────────────────────
    public int $paidOrdersCount        = 0;
    public int $deliveredOrdersCount   = 0;
    public int $buyerDisputesCount     = 0;
    public int $buyerDisputesWonCount  = 0;
    public float $totalTransactionAmount = 0;

    // ── Seller Stats ───────────────────────────────────────────────
    public int $soldOrdersCount        = 0;
    public int $sellerDisputesCount    = 0;
    public int $sellerDisputesWonCount = 0;
    public int $cancelledOrdersCount   = 0;
    public int $productsCount          = 0;

    // ── Personal Stats ─────────────────────────────────────────────
    public int $banHistoryCount           = 0;
    public int $withdrawalRequestsCount   = 0;
    public int $transactionsCount         = 0;

    // ── Search / Filter ────────────────────────────────────────────
    public string $orderSearch       = '';
    public string $transactionSearch = '';
    public string $pointSearch       = '';
    public string $withdrawalSearch  = '';

    protected $queryString = ['activeTab'];

    public function mount(User $user): void
    {
        $this->user = $user->load([
            'wallet',
            'userPoint',
            'userBans',
            'ranks',
            'seller',
        ]);

        $this->computeBuyerStats();
        $this->computeSellerStats();
        $this->computePersonalStats();
    }

    // ──────────────────────────────────────────────────────────────
    //  Tab switching — reset pagination when switching
    // ──────────────────────────────────────────────────────────────

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // ──────────────────────────────────────────────────────────────
    //  Stat helpers
    // ──────────────────────────────────────────────────────────────

    private function computeBuyerStats(): void
    {
        $uid = $this->user->id;

        $this->paidOrdersCount = Order::where('user_id', $uid)
            ->whereIn('status', [
                OrderStatus::PAID,
                OrderStatus::COMPLETED,
                OrderStatus::PARTIALLY_PAID,
                OrderStatus::PROCESSING,
            ])->count();

        $this->deliveredOrdersCount = Order::where('user_id', $uid)
            ->whereIn('status', [OrderStatus::DELIVERED, OrderStatus::COMPLETED])
            ->count();

        // Disputes as buyer (user_id on the dispute's order)
        $buyerOrderIds = Order::where('user_id', $uid)->pluck('id');

        $this->buyerDisputesCount = Dispute::whereIn('order_id', $buyerOrderIds)->count();

        // $this->buyerDisputesWonCount = Dispute::whereIn('order_id', $buyerOrderIds)
        //     ->where('winner_type', 'buyer')
        //     ->count();

        $this->totalTransactionAmount = (float) Transaction::where('user_id', $uid)
            ->where('status', \App\Enums\TransactionStatus::PAID)
            ->sum('amount');
    }

    private function computeSellerStats(): void
    {
        $uid = $this->user->id;

        $this->soldOrdersCount = Order::whereHasMorph(
            'source',
            [Product::class],
            fn ($q) => $q->where('user_id', $uid)
        )->whereIn('status', [OrderStatus::COMPLETED, OrderStatus::DELIVERED])->count();

        $sellerOrderIds = Order::whereHasMorph(
            'source',
            [Product::class],
            fn ($q) => $q->where('user_id', $uid)
        )->pluck('id');

        $this->sellerDisputesCount = Dispute::whereIn('order_id', $sellerOrderIds)->count();

        // $this->sellerDisputesWonCount = Dispute::whereIn('order_id', $sellerOrderIds)
        //     ->where('winner_type', 'seller')
        //     ->count();

        $this->cancelledOrdersCount = Order::whereHasMorph(
            'source',
            [Product::class],
            fn ($q) => $q->where('user_id', $uid)
        )->where('status', OrderStatus::CANCELLED)->count();

        $this->productsCount = Product::where('user_id', $uid)->count();
    }

    private function computePersonalStats(): void
    {
        $uid = $this->user->id;

        $this->banHistoryCount         = $this->user->userBans()->count();
        $this->transactionsCount       = Transaction::where('user_id', $uid)->count();
        $this->withdrawalRequestsCount = WithdrawalRequest::where('user_id', $uid)->count();
    }

    // ──────────────────────────────────────────────────────────────
    //  Paginated queries (called inside render so they stay reactive)
    // ──────────────────────────────────────────────────────────────

    private function getBuyerOrders()
    {
        return Order::where('user_id', $this->user->id)
            ->with(['source'])
            ->when($this->orderSearch, fn ($q, $s) => $q->where('order_id', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10, pageName: 'orderPage');
    }

    private function getTransactions()
    {
        return Transaction::where('user_id', $this->user->id)
            ->when($this->transactionSearch, fn ($q, $s) => $q->where('transaction_id', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10, pageName: 'txPage');
    }

    private function getPointLogs()
    {
        return PointLog::where('user_id', $this->user->id)
            ->when($this->pointSearch, fn ($q, $s) => $q->where('notes', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10, pageName: 'pointPage');
    }

    private function getWithdrawals()
    {
        return WithdrawalRequest::where('user_id', $this->user->id)
            ->when($this->withdrawalSearch, fn ($q, $s) => $q->where('id', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10, pageName: 'withdrawalPage');
    }

    private function getSellerOrders()
    {
        return Order::whereHasMorph(
            'source',
            [Product::class],
            fn ($q) => $q->where('user_id', $this->user->id)
        )->with(['user', 'source'])
            ->latest()
            ->paginate(10, pageName: 'sellerOrderPage');
    }

    // ──────────────────────────────────────────────────────────────
    //  Render
    // ──────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.profile.persona-info', [
            'buyerOrders'  => $this->activeTab === 'buyer'    ? $this->getBuyerOrders()  : null,
            'transactions' => $this->activeTab === 'buyer'    ? $this->getTransactions() : null,
            'sellerOrders' => $this->activeTab === 'seller'   ? $this->getSellerOrders() : null,
            'pointLogs'    => $this->activeTab === 'personal' ? $this->getPointLogs()    : null,
            'withdrawals'  => $this->activeTab === 'personal' ? $this->getWithdrawals()  : null,
            'activeRank'   => $this->user->ranks()->orderByPivot('activated_at', 'desc')->first(),
        ]);
    }
}