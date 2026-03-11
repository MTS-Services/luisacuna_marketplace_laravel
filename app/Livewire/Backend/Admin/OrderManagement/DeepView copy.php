<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Actions\Order\ResolveOrderAction;
use App\Models\Admin;
use App\Models\AdminStaffNote;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Models\UserDisputeStats;
use App\Models\UserSanction;
use App\Services\ConversationService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeepView extends Component
{
    use WithNotification;

    public Order $order;

    public ?User $buyer = null;

    public ?User $seller = null;

    public ?Dispute $dispute = null;

    public ?string $backUrl = null;

    /** @var Collection<int, \App\Models\Message> */
    public Collection $chatMessages;

    /** @var Collection<int, AdminStaffNote> */
    public Collection $staffNotes;

    public string $adminMessage = '';

    public string $staffNoteText = '';

    public string $resolutionType = '';

    public float $splitBuyerPercent = 50;

    public string $resolutionNotes = '';

    public string $sanctionTarget = '';

    public string $sanctionType = '';

    public string $sanctionReason = '';

    public string $sanctionDuration = '';

    public int $buyerTotalOrders = 0;

    public int $buyerCompletedOrders = 0;

    public int $buyerCancelledOrders = 0;

    public float $buyerTrustScore = 0;

    public int $buyerWins = 0;

    public int $buyerActiveDisputes = 0;

    public int $sellerTotalSales = 0;

    public int $sellerCompletedSales = 0;

    public int $sellerCancelledSales = 0;

    public float $sellerReputation = 0;

    public int $sellerLosses = 0;

    public int $sellerActiveDisputes = 0;

    public float $buyerDisputeRate = 0;

    public float $sellerDisputeRate = 0;

    public int $buyerLosses = 0;

    public int $sellerWins = 0;

    /** @var Collection<int, OrderStatusHistory> */
    public Collection $statusTimeline;

    /** @var Collection<int, \App\Models\OrderDelivery> */
    public Collection $deliveryRecords;

    protected ConversationService $conversationService;

    protected ResolveOrderAction $resolveOrderAction;

    public function boot(
        ConversationService $conversationService,
        ResolveOrderAction $resolveOrderAction,
    ): void {
        $this->conversationService = $conversationService;
        $this->resolveOrderAction = $resolveOrderAction;
    }

    public function mount(Order $data): void
    {
        $this->order = $data;
        $this->order->load([
            'user',
            'source.user',
            'source.game',
            'conversation.messages.sender',
            'staffNotes.admin',
            'transactions',
            'feedbacks.author',
        ]);

        $this->buyer = $this->order->user;
        $this->seller = $this->order->source?->user;

        $this->dispute = Dispute::query()
            ->where('order_id', $this->order->id)
            ->latest('id')
            ->with(['messages.sender', 'attachments'])
            ->first();

        $this->loadChatMessages();
        $this->loadStaffNotes();
        $this->loadUserStats();
        $this->loadStatusTimeline();
        $this->loadDeliveryRecords();

        $this->backUrl = url()->previous() !== url()->current()
            ? url()->previous()
            : route('admin.orders.dispute-orders');
    }

    protected function loadChatMessages(): void
    {
        $conversation = $this->order->conversation;

        if ($conversation) {
            $this->chatMessages = $conversation->messages()
                ->with('sender')
                ->orderBy('created_at')
                ->get();
        } else {
            $this->chatMessages = collect();
        }
    }

    protected function loadStaffNotes(): void
    {
        $this->staffNotes = $this->order->staffNotes()
            ->with('admin')
            ->get();
    }

    protected function loadUserStats(): void
    {
        if ($this->buyer) {
            $this->buyerTotalOrders = Order::where('user_id', $this->buyer->id)
                ->whereNotIn('status', ['initialized'])->count();
            $this->buyerCompletedOrders = Order::where('user_id', $this->buyer->id)
                ->where('status', 'completed')->count();
            $this->buyerCancelledOrders = Order::where('user_id', $this->buyer->id)
                ->where('status', 'cancelled')->count();
            $this->buyerTrustScore = $this->buyerTotalOrders > 0
                ? round(($this->buyerCompletedOrders / $this->buyerTotalOrders) * 100, 1)
                : 0;
            $this->buyerWins = Dispute::where('buyer_id', $this->buyer->id)
                ->where('status', 'resolved_buyer_wins')->count();
            $this->buyerLosses = Dispute::where('buyer_id', $this->buyer->id)
                ->where('status', 'resolved_seller_wins')->count();
            $this->buyerActiveDisputes = Dispute::where('buyer_id', $this->buyer->id)
                ->whereIn('status', ['pending_vendor', 'pending_review', 'escalated'])->count();

            $buyerStats = UserDisputeStats::where('user_id', $this->buyer->id)->first();
            $this->buyerDisputeRate = $buyerStats?->dispute_rate ?? 0;
        }

        if ($this->seller) {
            $sellerProductIds = $this->seller->products()->pluck('id');
            $this->sellerTotalSales = Order::where('source_type', \App\Models\Product::class)
                ->whereIn('source_id', $sellerProductIds)
                ->whereNotIn('status', ['initialized'])->count();
            $this->sellerCompletedSales = Order::where('source_type', \App\Models\Product::class)
                ->whereIn('source_id', $sellerProductIds)
                ->where('status', 'completed')->count();
            $this->sellerCancelledSales = Order::where('source_type', \App\Models\Product::class)
                ->whereIn('source_id', $sellerProductIds)
                ->where('status', 'cancelled')->count();
            $this->sellerReputation = $this->sellerTotalSales > 0
                ? round(($this->sellerCompletedSales / $this->sellerTotalSales) * 100, 1)
                : 0;
            $this->sellerWins = Dispute::where('vendor_id', $this->seller->id)
                ->where('status', 'resolved_seller_wins')->count();
            $this->sellerLosses = Dispute::where('vendor_id', $this->seller->id)
                ->where('status', 'resolved_buyer_wins')->count();
            $this->sellerActiveDisputes = Dispute::where('vendor_id', $this->seller->id)
                ->whereIn('status', ['pending_vendor', 'pending_review', 'escalated'])->count();

            $sellerStats = UserDisputeStats::where('user_id', $this->seller->id)->first();
            $this->sellerDisputeRate = $sellerStats?->dispute_rate ?? 0;
        }
    }

    protected function loadStatusTimeline(): void
    {
        $this->statusTimeline = $this->order->statusHistories()
            ->orderBy('created_at')
            ->get();
    }

    protected function loadDeliveryRecords(): void
    {
        $this->deliveryRecords = $this->order->orderDeliveries()
            ->with('seller')
            ->get();
    }

    public function sendAdminMessage(): void
    {
        $this->validate(['adminMessage' => 'required|string|max:2000']);

        $conversation = $this->order->conversation;

        if (! $conversation) {
            $this->error(__('No conversation found for this order.'));

            return;
        }

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $this->conversationService->adminSendMessage(
            $conversation,
            $admin,
            $this->adminMessage,
            \App\Enums\MessageType::TEXT,
        );

        $this->adminMessage = '';
        $this->loadChatMessages();
        $this->success(__('Message sent.'));
    }

    public function addStaffNote(): void
    {
        $this->validate(['staffNoteText' => 'required|string|max:2000']);

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        AdminStaffNote::query()->create([
            'order_id' => $this->order->id,
            'admin_id' => $admin->id,
            'note' => $this->staffNoteText,
        ]);

        $this->staffNoteText = '';
        $this->loadStaffNotes();
        $this->success(__('Staff note added.'));
    }

    public function resolveOrder(): void
    {
        $this->validate([
            'resolutionType' => 'required|in:buyer_wins,seller_wins,partial_split,neutral_cancel',
            'resolutionNotes' => 'nullable|string|max:2000',
        ]);

        if ($this->resolutionType === 'partial_split') {
            $this->validate([
                'splitBuyerPercent' => 'required|numeric|min:0|max:100',
            ]);
        }

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $escrowTotal = (float) $this->order->getDefaultGrandTotal();

        $data = [
            'resolution_type' => $this->resolutionType,
            'notes' => $this->resolutionNotes ?: null,
        ];

        if ($this->resolutionType === 'partial_split') {
            $data['buyer_amount'] = round($escrowTotal * ($this->splitBuyerPercent / 100), 2);
            $data['seller_amount'] = round($escrowTotal - $data['buyer_amount'], 2);
        }

        try {
            $this->order = $this->resolveOrderAction->execute($this->order, $admin, $data);
            $this->order->load(['user', 'source.user', 'source.game', 'staffNotes.admin', 'transactions']);
            $this->loadChatMessages();
            $this->success(__('Order resolved successfully.'));
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());
        } catch (\Throwable $e) {
            $this->error(__('Failed to resolve order: ').$e->getMessage());
        }
    }

    public function applySanction(): void
    {
        $this->validate([
            'sanctionTarget' => 'required|in:buyer,seller',
            'sanctionType' => 'required|in:force_kyc,freeze_wallet,suspend,ban_hwid',
            'sanctionReason' => 'required|string|min:10|max:2000',
            'sanctionDuration' => 'required|string|max:100',
        ]);

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $targetUser = $this->sanctionTarget === 'buyer' ? $this->buyer : $this->seller;

        if (! $targetUser) {
            $this->error(__('Target user not found.'));

            return;
        }

        $expiresAt = match ($this->sanctionDuration) {
            '24h' => now()->addHours(24),
            '7d' => now()->addDays(7),
            '30d' => now()->addDays(30),
            '90d' => now()->addDays(90),
            'permanent' => null,
            default => now()->addDays(30),
        };

        UserSanction::query()->create([
            'user_id' => $targetUser->id,
            'admin_id' => $admin->id,
            'type' => $this->sanctionType,
            'reason' => $this->sanctionReason,
            'duration' => $this->sanctionDuration,
            'expires_at' => $expiresAt,
            'is_active' => true,
        ]);

        $this->reset('sanctionTarget', 'sanctionType', 'sanctionReason', 'sanctionDuration');
        $this->success(__('Sanction applied successfully.'));
    }

    /**
     * Computed property for slider amounts.
     */
    public function getEscrowTotalProperty(): float
    {
        return (float) $this->order->getDefaultGrandTotal();
    }

    public function getBuyerAmountProperty(): float
    {
        return round($this->escrowTotal * ($this->splitBuyerPercent / 100), 2);
    }

    public function getSellerAmountProperty(): float
    {
        return round($this->escrowTotal - $this->buyerAmount, 2);
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.deep-view');
    }
}
