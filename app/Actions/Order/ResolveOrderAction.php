<?php

namespace App\Actions\Order;

use App\Enums\DisputeStatus;
use App\Enums\OrderStatus;
use App\Enums\ResolutionType;
use App\Models\Admin;
use App\Models\Dispute;
use App\Models\Order;
use App\Services\OrderStateMachine;
use Illuminate\Support\Facades\Log;

class ResolveOrderAction
{
    public function __construct(
        protected OrderStateMachine $stateMachine,
    ) {}

    /**
     * Resolve an escalated order with one of the 4 resolution outcomes.
     *
     * @param array{
     *     resolution_type: string,
     *     buyer_amount?: float,
     *     seller_amount?: float,
     *     notes?: string,
     * } $data
     */
    public function execute(Order $order, Admin $admin, array $data): Order
    {
        $resolutionType = ResolutionType::from($data['resolution_type']);
        $escrowTotal = (float) ($order->getDefaultGrandTotal() - $order->getDefaultTaxAmount());

        $buyerAmount = match ($resolutionType) {
            ResolutionType::BuyerWins => $escrowTotal,
            ResolutionType::SellerWins => 0.0,
            ResolutionType::PartialSplit => (float) ($data['buyer_amount'] ?? 0),
            ResolutionType::NeutralCancel => $escrowTotal,
        };

        $sellerAmount = match ($resolutionType) {
            ResolutionType::BuyerWins => 0.0,
            ResolutionType::SellerWins => $escrowTotal,
            ResolutionType::PartialSplit => (float) ($data['seller_amount'] ?? 0),
            ResolutionType::NeutralCancel => 0.0,
        };

        if ($resolutionType === ResolutionType::PartialSplit) {
            $total = $buyerAmount + $sellerAmount;
            if (abs($total - $escrowTotal) > 0.01) {
                throw new \InvalidArgumentException(
                    "Partial split amounts ({$buyerAmount} + {$sellerAmount} = {$total}) must equal escrow total ({$escrowTotal})."
                );
            }
        }

        $order = $this->stateMachine->transition(
            order: $order,
            targetStatus: OrderStatus::RESOLVED,
            actor: null,
            meta: [
                'resolution_type' => $resolutionType->value,
                'buyer_amount' => $buyerAmount,
                'seller_amount' => $sellerAmount,
                'resolved_by' => $admin->id,
                'notes' => $data['notes'] ?? null,
            ],
        );

        $this->updateDisputeRecord($order, $resolutionType, $admin);

        return $order;
    }

    /**
     * Update the related dispute record to reflect the resolution.
     */
    protected function updateDisputeRecord(Order $order, ResolutionType $resolutionType, Admin $admin): void
    {
        try {
            $dispute = Dispute::query()
                ->where('order_id', $order->id)
                ->whereIn('status', [
                    DisputeStatus::PENDING_VENDOR->value,
                    DisputeStatus::PENDING_REVIEW->value,
                    DisputeStatus::ESCALATED->value,
                ])
                ->latest('id')
                ->first();

            if (! $dispute) {
                return;
            }

            $disputeStatus = match ($resolutionType) {
                ResolutionType::BuyerWins => DisputeStatus::RESOLVED_BUYER_WINS,
                ResolutionType::SellerWins => DisputeStatus::RESOLVED_SELLER_WINS,
                ResolutionType::PartialSplit => DisputeStatus::RESOLVED_PARTIAL_SPLIT,
                ResolutionType::NeutralCancel => DisputeStatus::RESOLVED_NEUTRAL,
            };

            $dispute->update([
                'status' => $disputeStatus,
                'resolved_at' => now(),
            ]);

            $dispute->messages()->create([
                'sender_id' => $admin->id,
                'sender_role' => 'admin',
                'message' => __('Resolution applied: :type', ['type' => $resolutionType->label()]),
                'meta' => [
                    'status' => $disputeStatus->value,
                    'system' => true,
                    'resolution_type' => $resolutionType->value,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to update dispute record after resolution', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
