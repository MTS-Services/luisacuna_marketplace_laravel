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

    public ?User $buyer  = null;
    public ?User $seller = null;

    public ?Dispute $dispute = null;

    public ?string $backUrl = null;

    /** @var Collection<int, \App\Models\Message> */
    public Collection $chatMessages;

    /** @var Collection<int, AdminStaffNote> */
    public Collection $staffNotes;

    /** @var Collection<int, OrderStatusHistory> */
    public Collection $statusTimeline;

    /** @var Collection<int, \App\Models\OrderDelivery> */
    public Collection $deliveryRecords;

    // ── Form fields ──────────────────────────────────────────────────────────
    public string $adminMessage      = '';
    public string $staffNoteText     = '';
    public string $resolutionType    = '';
    public float  $splitBuyerPercent = 50;
    public string $resolutionNotes   = '';
    public string $sanctionTarget    = '';
    public string $sanctionType      = '';
    public string $sanctionReason    = '';
    public string $sanctionDuration  = '';

    // ── Escrow amounts — public so Blade & Alpine can read them ─────────────
    public float $escrowTotal  = 0;
    public float $buyerAmount  = 0;
    public float $sellerAmount = 0;

    // ── Buyer stats ──────────────────────────────────────────────────────────
    public int   $buyerTotalOrders     = 0;
    public int   $buyerCompletedOrders = 0;
    public int   $buyerCancelledOrders = 0;
    public float $buyerTrustScore      = 0;
    public int   $buyerWins            = 0;
    public int   $buyerLosses          = 0;
    public int   $buyerActiveDisputes  = 0;
    public float $buyerDisputeRate     = 0;

    // ── Seller stats ─────────────────────────────────────────────────────────
    public int   $sellerTotalSales     = 0;
    public int   $sellerCompletedSales = 0;
    public int   $sellerCancelledSales = 0;
    public float $sellerReputation     = 0;
    public int   $sellerWins           = 0;
    public int   $sellerLosses         = 0;
    public int   $sellerActiveDisputes = 0;
    public float $sellerDisputeRate    = 0;

    // ── Profile extras ───────────────────────────────────────────────────────
    public string $buyerCountry     = '';
    public string $buyerCountryCode = '';
    public string $buyerSellerSince = '';
    public string $buyerLastIp      = '';
    public bool   $buyerIpMatch     = false;

    public string $sellerCountry     = '';
    public string $sellerCountryCode = '';
    public string $sellerSellerSince = '';
    public string $sellerLastIp      = '';
    public bool   $sellerIpMatch     = false;

    public bool $sameIpDetected = false;

    // ── Timer (computed on mount, counting done in Alpine) ───────────────────
    public int  $orderDelaySeconds = 0;
    public bool $isOverdue         = false;

    // ─────────────────────────────────────────────────────────────────────────

    protected ConversationService $conversationService;
    protected ResolveOrderAction  $resolveOrderAction;

    public function boot(
        ConversationService $conversationService,
        ResolveOrderAction  $resolveOrderAction,
    ): void {
        $this->conversationService = $conversationService;
        $this->resolveOrderAction  = $resolveOrderAction;
    }

    public function mount(Order $data): void
    {
        $this->order = $data;
        $this->order->load([
            'user.country',
            'user.seller',
            'source.user.country',
            'source.user.seller',
            'source.game',
            'conversation.messages.sender',
            'staffNotes.admin',
            'transactions',
        ]);

        $this->buyer  = $this->order->user;
        $this->seller = $this->order->source?->user;

        $this->dispute = Dispute::query()
            ->where('order_id', $this->order->id)
            ->latest('id')
            ->with(['messages.sender', 'attachments'])
            ->first();

        // Escrow totals
        $this->escrowTotal  = (float) $this->order->getDefaultGrandTotal();
        $this->recalcAmounts();

        $this->loadChatMessages();
        $this->loadStaffNotes();
        $this->loadUserStats();
        $this->loadExtendedProfiles();
        $this->loadStatusTimeline();
        $this->loadDeliveryRecords();
        $this->calculateOrderDelay();

        $this->backUrl = url()->previous() !== url()->current()
            ? url()->previous()
            : route('admin.orders.dispute-orders');
    }

    // ── Lifecycle hooks ───────────────────────────────────────────────────────

    /** Recalculate split amounts whenever the slider changes. */
    public function updatedSplitBuyerPercent(): void
    {
        $this->recalcAmounts();
    }

    protected function recalcAmounts(): void
    {
        $this->buyerAmount  = round($this->escrowTotal * ($this->splitBuyerPercent / 100), 2);
        $this->sellerAmount = round($this->escrowTotal - $this->buyerAmount, 2);
    }

    // ── Data loaders ─────────────────────────────────────────────────────────

    public function loadChatMessages(): void
    {
        $conversation = $this->order->conversation;

        $this->chatMessages = $conversation
            ? $conversation->messages()->with('sender')->orderBy('created_at')->get()
            : collect();
    }

    public function loadStaffNotes(): void
    {
        $this->staffNotes = $this->order->staffNotes()
            ->with('admin')
            ->orderByDesc('created_at')
            ->get();
    }

    protected function loadUserStats(): void
    {
        if ($this->buyer) {
            $bid = $this->buyer->id;

            $this->buyerTotalOrders     = Order::where('user_id', $bid)->whereNotIn('status', ['initialized'])->count();
            $this->buyerCompletedOrders = Order::where('user_id', $bid)->where('status', 'completed')->count();
            $this->buyerCancelledOrders = Order::where('user_id', $bid)->where('status', 'cancelled')->count();
            $this->buyerTrustScore      = $this->buyerTotalOrders > 0
                ? round(($this->buyerCompletedOrders / $this->buyerTotalOrders) * 100, 1)
                : 0;
            $this->buyerWins           = Dispute::where('buyer_id', $bid)->where('status', 'resolved_buyer_wins')->count();
            $this->buyerLosses         = Dispute::where('buyer_id', $bid)->where('status', 'resolved_seller_wins')->count();
            $this->buyerActiveDisputes = Dispute::where('buyer_id', $bid)
                ->whereIn('status', ['pending_vendor', 'pending_review', 'escalated'])
                ->count();
            $this->buyerDisputeRate = (float) (UserDisputeStats::where('user_id', $bid)->value('dispute_rate') ?? 0);
        }

        if ($this->seller) {
            $sid              = $this->seller->id;
            $sellerProductIds = $this->seller->products()->pluck('id');

            $this->sellerTotalSales     = Order::where('source_type', \App\Models\Product::class)->whereIn('source_id', $sellerProductIds)->whereNotIn('status', ['initialized'])->count();
            $this->sellerCompletedSales = Order::where('source_type', \App\Models\Product::class)->whereIn('source_id', $sellerProductIds)->where('status', 'completed')->count();
            $this->sellerCancelledSales = Order::where('source_type', \App\Models\Product::class)->whereIn('source_id', $sellerProductIds)->where('status', 'cancelled')->count();
            $this->sellerReputation     = $this->sellerTotalSales > 0
                ? round(($this->sellerCompletedSales / $this->sellerTotalSales) * 100, 1)
                : 0;
            $this->sellerWins           = Dispute::where('vendor_id', $sid)->where('status', 'resolved_seller_wins')->count();
            $this->sellerLosses         = Dispute::where('vendor_id', $sid)->where('status', 'resolved_buyer_wins')->count();
            $this->sellerActiveDisputes = Dispute::where('vendor_id', $sid)
                ->whereIn('status', ['pending_vendor', 'pending_review', 'escalated'])
                ->count();
            $this->sellerDisputeRate = (float) (UserDisputeStats::where('user_id', $sid)->value('dispute_rate') ?? 0);
        }
    }

    protected function loadExtendedProfiles(): void
    {
        if ($this->buyer) {
            $this->buyerCountry     = $this->buyer->country?->name ?? '';
            $this->buyerCountryCode = strtolower($this->buyer->country?->code ?? '');
            $this->buyerLastIp      = $this->buyer->last_login_ip ?? '';
            $this->buyerSellerSince = $this->buyer->seller?->seller_verified_at?->format('d M Y') ?? 'No Application';
        }

        if ($this->seller) {
            $this->sellerCountry     = $this->seller->country?->name ?? '';
            $this->sellerCountryCode = strtolower($this->seller->country?->code ?? '');
            $this->sellerLastIp      = $this->seller->last_login_ip ?? '';
            $this->sellerSellerSince = $this->seller->seller?->seller_verified_at?->format('d M Y') ?? 'No Application';
        }

        if ($this->buyerLastIp && $this->sellerLastIp && $this->buyerLastIp === $this->sellerLastIp) {
            $this->sameIpDetected = true;
            $this->buyerIpMatch   = true;
            $this->sellerIpMatch  = true;
        }
    }

    protected function loadStatusTimeline(): void
    {
        $this->statusTimeline = $this->order->statusHistories()->orderBy('created_at')->get();
    }

    protected function loadDeliveryRecords(): void
    {
        $this->deliveryRecords = $this->order->orderDeliveries()
            ->with('seller')
            ->orderByDesc('created_at')
            ->get();
    }

    protected function calculateOrderDelay(): void
    {
        if ($this->order->auto_completes_at) {
            $diff                    = now()->diffInSeconds($this->order->auto_completes_at, false);
            $this->orderDelaySeconds = (int) abs($diff);
            $this->isOverdue         = $diff < 0;
        } elseif ($this->order->escalated_at) {
            $this->orderDelaySeconds = (int) now()->diffInSeconds($this->order->escalated_at, false);
            $this->isOverdue         = true;
        }
    }

    // ── Chat & Notes ─────────────────────────────────────────────────────────

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
    }

    public function addStaffNote(): void
    {
        $this->validate(['staffNoteText' => 'required|string|max:2000']);

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        AdminStaffNote::query()->create([
            'order_id' => $this->order->id,
            'admin_id' => $admin->id,
            'note'     => $this->staffNoteText,
        ]);

        $this->staffNoteText = '';
        $this->loadStaffNotes();
    }

    // ── Resolution ───────────────────────────────────────────────────────────

    /** Award full escrow to buyer (100% refund). */
    public function awardBuyer(): void
    {
        $this->resolutionType = 'buyer_wins';
        $this->doResolve();
    }

    /** Award full escrow to seller. */
    public function awardSeller(): void
    {
        $this->resolutionType = 'seller_wins';
        $this->doResolve();
    }

    /** Apply the current split ratio. */
    public function applySplit(): void
    {
        $this->resolutionType = 'partial_split';
        $this->doResolve();
    }

    /** Neutral cancel — full refund, no winner. */
    public function applyNeutralCancel(): void
    {
        $this->resolutionType = 'neutral_cancel';
        $this->doResolve();
    }

    protected function doResolve(): void
    {
        $this->validate([
            'resolutionType'  => 'required|in:buyer_wins,seller_wins,partial_split,neutral_cancel',
            'resolutionNotes' => 'nullable|string|max:2000',
        ]);

        if ($this->resolutionType === 'partial_split') {
            $this->validate(['splitBuyerPercent' => 'required|numeric|min:0|max:100']);
            $this->recalcAmounts();
        }

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $data = [
            'resolution_type' => $this->resolutionType,
            'notes'           => $this->resolutionNotes ?: null,
        ];

        if ($this->resolutionType === 'partial_split') {
            $data['buyer_amount']  = $this->buyerAmount;
            $data['seller_amount'] = $this->sellerAmount;
        }

        try {
            $this->order = $this->resolveOrderAction->execute($this->order, $admin, $data);
            $this->order->load(['user', 'source.user', 'source.game', 'staffNotes.admin', 'transactions']);
            $this->loadChatMessages();
            $this->success(__('Order resolved successfully.'));
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());
        } catch (\Throwable $e) {
            $this->error(__('Failed to resolve order: ') . $e->getMessage());
        }
    }

    // ── Sanctions ────────────────────────────────────────────────────────────

    public function applySanction(): void
    {
        $this->validate([
            'sanctionTarget'   => 'required|in:buyer,seller',
            'sanctionType'     => 'required|in:force_kyc,freeze_wallet,suspend,ban_hwid',
            'sanctionReason'   => 'required|string|min:10|max:2000',
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
            '24h'       => now()->addHours(24),
            '7d'        => now()->addDays(7),
            '30d'       => now()->addDays(30),
            '90d'       => now()->addDays(90),
            'permanent' => null,
            default     => now()->addDays(30),
        };

        UserSanction::query()->create([
            'user_id'    => $targetUser->id,
            'admin_id'   => $admin->id,
            'type'       => $this->sanctionType,
            'reason'     => $this->sanctionReason,
            'duration'   => $this->sanctionDuration,
            'expires_at' => $expiresAt,
            'is_active'  => true,
        ]);

        $this->reset('sanctionTarget', 'sanctionType', 'sanctionReason', 'sanctionDuration');
        $this->success(__('Sanction applied successfully.'));
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.deep-view');
    }
}
