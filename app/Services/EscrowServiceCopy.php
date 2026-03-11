<?php

namespace App\Services;

use App\Enums\CalculationType;
use App\Enums\ResolutionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EscrowServiceCopy
{
    /**
     * Release full escrow funds to the seller's wallet.
     * Used when buyer confirms delivery or 72h auto-completion.
     */
    public function releaseFundsToSeller(Order $order): void
    {
        $order->loadMissing(['source.user']);
        $seller = $order->source?->user;

        if (! $seller) {
            Log::error('EscrowService: Seller not found for fund release', ['order_id' => $order->order_id]);

            return;
        }

        $amount = (float) $order->getDefaultGrandTotal();

        if ($amount <= 0) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $seller->id],
            ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
        );

        $feeAmount = $this->calculatePlatformFee($order);
        $netAmount = $amount - $feeAmount;

        DB::transaction(function () use ($wallet, $order, $seller, $amount, $feeAmount, $netAmount) {
            $wallet->lockForUpdate();
            $wallet->increment('balance', $netAmount);

            $newBalance = (float) $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $seller->id,
                'type' => TransactionType::SALES,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'currency' => $order->default_currency ?? 'USD',
                'balance_snapshot' => $newBalance,
                'order_id' => $order->id,
                'notes' => "Escrow release for order #{$order->order_id}",
                'processed_at' => now(),
            ]);
        });
    }

    /**
     * Refund full escrow to the buyer's wallet.
     * Used when order is cancelled or buyer wins dispute.
     */
    public function refundBuyer(Order $order): void
    {
        $buyer = $order->user;

        if (! $buyer) {
            Log::error('EscrowService: Buyer not found for refund', ['order_id' => $order->order_id]);

            return;
        }

        $amount = (float) $order->getDefaultGrandTotal();

        if ($amount <= 0) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $buyer->id],
            ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
        );

        DB::transaction(function () use ($wallet, $order, $buyer, $amount) {
            $wallet->lockForUpdate();
            $wallet->increment('balance', $amount);

            $newBalance = (float) $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $buyer->id,
                'type' => TransactionType::REFUND,
                'status' => TransactionStatus::PAID,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $amount,
                'fee_amount' => 0,
                'net_amount' => $amount,
                'currency' => $order->default_currency ?? 'USD',
                'balance_snapshot' => $newBalance,
                'order_id' => $order->id,
                'notes' => "Escrow refund for order #{$order->order_id}",
                'processed_at' => now(),
            ]);
        });
    }

    /**
     * Release funds to seller with a 3-day security hold (pending_balance).
     * Used when admin rules "Seller Wins".
     */
    public function releaseFundsWithHold(Order $order): void
    {
        $order->loadMissing(['source.user']);
        $seller = $order->source?->user;

        if (! $seller) {
            Log::error('EscrowService: Seller not found for held release', ['order_id' => $order->order_id]);

            return;
        }

        $amount = (float) $order->getDefaultGrandTotal();

        if ($amount <= 0) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $seller->id],
            ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
        );

        $feeAmount = $this->calculatePlatformFee($order);
        $netAmount = $amount - $feeAmount;

        DB::transaction(function () use ($wallet, $order, $seller, $amount, $feeAmount, $netAmount) {
            $wallet->lockForUpdate();
            $wallet->increment('pending_balance', $netAmount);

            $newBalance = (float) $wallet->fresh()->balance;

            Transaction::query()->create([
                'user_id' => $seller->id,
                'type' => TransactionType::SALES,
                'status' => TransactionStatus::PENDING,
                'calculation_type' => CalculationType::DEBIT,
                'amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'currency' => $order->default_currency ?? 'USD',
                'balance_snapshot' => $newBalance,
                'order_id' => $order->id,
                'notes' => "Escrow release with 3-day hold for order #{$order->order_id}",
                'metadata' => [
                    'hold_type' => 'seller_wins',
                    'release_at' => now()->addDays(3)->toIso8601String(),
                ],
                'processed_at' => now(),
            ]);
        });
    }

    /**
     * Apply a partial split: divide the escrow between buyer and seller mathematically.
     */
    public function applyPartialSplit(Order $order, float $buyerAmount, float $sellerAmount): void
    {
        $order->loadMissing(['user', 'source.user']);
        $buyer = $order->user;
        $seller = $order->source?->user;

        if (! $buyer || ! $seller) {
            Log::error('EscrowService: Buyer or seller not found for partial split', ['order_id' => $order->order_id]);

            return;
        }

        DB::transaction(function () use ($order, $buyer, $seller, $buyerAmount, $sellerAmount) {
            if ($buyerAmount > 0) {
                $buyerWallet = Wallet::query()->firstOrCreate(
                    ['user_id' => $buyer->id],
                    ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
                );
                $buyerWallet->lockForUpdate();
                $buyerWallet->increment('balance', $buyerAmount);

                $newBuyerBalance = (float) $buyerWallet->fresh()->balance;

                Transaction::query()->create([
                    'user_id' => $buyer->id,
                    'type' => TransactionType::REFUND,
                    'status' => TransactionStatus::PAID,
                    'calculation_type' => CalculationType::DEBIT,
                    'amount' => $buyerAmount,
                    'fee_amount' => 0,
                    'net_amount' => $buyerAmount,
                    'currency' => $order->default_currency ?? 'USD',
                    'balance_snapshot' => $newBuyerBalance,
                    'order_id' => $order->id,
                    'notes' => "Partial split refund (buyer portion) for order #{$order->order_id}",
                    'processed_at' => now(),
                ]);
            }

            if ($sellerAmount > 0) {
                $sellerWallet = Wallet::query()->firstOrCreate(
                    ['user_id' => $seller->id],
                    ['currency_code' => $order->default_currency ?? 'USD', 'balance' => 0],
                );
                $sellerWallet->lockForUpdate();
                $sellerWallet->increment('balance', $sellerAmount);

                $newSellerBalance = (float) $sellerWallet->fresh()->balance;

                Transaction::query()->create([
                    'user_id' => $seller->id,
                    'type' => TransactionType::SALES,
                    'status' => TransactionStatus::PAID,
                    'calculation_type' => CalculationType::DEBIT,
                    'amount' => $sellerAmount,
                    'fee_amount' => 0,
                    'net_amount' => $sellerAmount,
                    'currency' => $order->default_currency ?? 'USD',
                    'balance_snapshot' => $newSellerBalance,
                    'order_id' => $order->id,
                    'notes' => "Partial split payment (seller portion) for order #{$order->order_id}",
                    'processed_at' => now(),
                ]);
            }
        });
    }

    /**
     * Apply resolution based on the ResolutionType enum.
     */
    public function applyResolution(Order $order, ResolutionType $resolution): void
    {
        match ($resolution) {
            ResolutionType::BuyerWins => $this->refundBuyer($order),
            ResolutionType::SellerWins => $this->releaseFundsWithHold($order),
            ResolutionType::PartialSplit => $this->applyPartialSplit(
                $order,
                (float) $order->resolution_buyer_amount,
                (float) $order->resolution_seller_amount,
            ),
            ResolutionType::NeutralCancel => $this->refundBuyer($order),
        };
    }

    /**
     * Calculate platform fee for seller payouts.
     */
    protected function calculatePlatformFee(Order $order): float
    {
        $salesTransaction = Transaction::query()
            ->where('order_id', $order->id)
            ->where('type', TransactionType::SALES)
            ->where('status', TransactionStatus::PAID)
            ->first();

        if ($salesTransaction) {
            return (float) $salesTransaction->fee_amount;
        }

        $purchaseTransaction = Transaction::query()
            ->where('order_id', $order->id)
            ->where('type', TransactionType::PURCHSED)
            ->where('status', TransactionStatus::PAID)
            ->first();

        if ($purchaseTransaction) {
            return (float) $purchaseTransaction->fee_amount;
        }

        return 0;
    }
}
