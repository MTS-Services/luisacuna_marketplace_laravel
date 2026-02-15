<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class TaxService
{
    public function __construct(
        protected FeeSettingsService $feeSettingsService,
        protected CurrencyService $currencyService
    ) {}

    /**
     * Calculate tax for a payment method
     *
     * Rules:
     * 1. Wallet: No tax
     * 2. Stripe/Crypto: Tax on entire amount
     * 3. Wallet with top-up: Tax only on remaining balance to be paid
     *
     * @param  string  $paymentMethod  Payment method (wallet, stripe, crypto, etc.)
     * @param  float  $amountDefault  Amount in default currency
     * @param  float  $walletBalanceDefault  Wallet balance in default currency (if wallet payment)
     * @param  bool  $isTopUp  Whether this is a top-up scenario
     * @return array ['tax_amount_default' => float, 'grand_total_default' => float]
     */
    public function calculateTax(
        string $paymentMethod,
        float $amountDefault,
        ?float $walletBalanceDefault = null,
        bool $isTopUp = false
    ): array {
        $taxAmountDefault = 0;
        $grandTotalDefault = $amountDefault;

        try {
            // Rule 1: Wallet payment with sufficient balance - NO TAX
            if ($paymentMethod === 'wallet' && ! $isTopUp) {
                return [
                    'tax_amount_default' => 0,
                    'grand_total_default' => $amountDefault,
                    'tax_applied' => false,
                    'scenario' => 'wallet_sufficient_balance',
                ];
            }

            // Rule 2: Wallet payment with insufficient balance (top-up) - TAX ONLY ON REMAINDER
            if ($paymentMethod === 'wallet' && $isTopUp && $walletBalanceDefault !== null) {
                $remainingBalance = $amountDefault - $walletBalanceDefault;

                if ($remainingBalance > 0) {
                    $fee = $this->feeSettingsService->getActiveFee();
                    $buyerTaxPercent = (float) ($fee->buyer_fee ?? 0);

                    // Tax only on remaining balance
                    $taxAmountDefault = ($remainingBalance * $buyerTaxPercent) / 100;
                }

                return [
                    'tax_amount_default' => $taxAmountDefault,
                    'grand_total_default' => $amountDefault + $taxAmountDefault,
                    'tax_applied' => $taxAmountDefault > 0,
                    'scenario' => 'wallet_insufficient_with_topup',
                    'wallet_balance' => $walletBalanceDefault,
                    'remaining_to_pay' => max(0, $amountDefault - $walletBalanceDefault),
                ];
            }

            // Rule 3: Other payment methods (Stripe, Crypto, etc.) - TAX ON ENTIRE AMOUNT
            if (in_array($paymentMethod, ['stripe', 'crypto', 'nowpayments', 'paypal'])) {
                $fee = $this->feeSettingsService->getActiveFee();
                $buyerTaxPercent = (float) ($fee->buyer_fee ?? 0);

                // Tax on entire amount
                $taxAmountDefault = ($amountDefault * $buyerTaxPercent) / 100;

                return [
                    'tax_amount_default' => $taxAmountDefault,
                    'grand_total_default' => $amountDefault + $taxAmountDefault,
                    'tax_applied' => $taxAmountDefault > 0,
                    'scenario' => 'other_payment_method',
                    'buyer_fee_percent' => $buyerTaxPercent,
                ];
            }

            // Default: no tax if payment method not recognized
            return [
                'tax_amount_default' => 0,
                'grand_total_default' => $amountDefault,
                'tax_applied' => false,
                'scenario' => 'unknown_payment_method',
            ];
        } catch (\Exception $e) {
            Log::error('Tax calculation error', [
                'payment_method' => $paymentMethod,
                'amount_default' => $amountDefault,
                'error' => $e->getMessage(),
            ]);

            return [
                'tax_amount_default' => 0,
                'grand_total_default' => $amountDefault,
                'tax_applied' => false,
                'error' => true,
                'error_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Convert tax amounts from default currency to display currency
     *
     * @param  float  $taxAmountDefault  Tax in default currency
     * @param  string  $displayCurrency  Display currency code
     * @return array ['tax_amount_display' => float]
     */
    public function convertTaxToDisplayCurrency(float $taxAmountDefault, string $displayCurrency): array
    {
        try {
            $taxAmountDisplay = $this->currencyService->convertFromDefault(
                $taxAmountDefault,
                $displayCurrency
            );

            return [
                'tax_amount_display' => $taxAmountDisplay,
            ];
        } catch (\Exception $e) {
            Log::error('Tax currency conversion error', [
                'tax_amount_default' => $taxAmountDefault,
                'display_currency' => $displayCurrency,
                'error' => $e->getMessage(),
            ]);

            return [
                'tax_amount_display' => 0,
                'error' => true,
            ];
        }
    }

    /**
     * Update order with tax information
     *
     * @param  float  $taxAmountDefault  Tax in default currency
     * @param  float  $taxAmountDisplay  Tax in display currency
     * @param  float  $grandTotalDefault  Grand total in default currency
     * @param  float  $grandTotalDisplay  Grand total in display currency
     */
    public function updateOrderWithTax(
        Order $order,
        float $taxAmountDefault,
        float $taxAmountDisplay,
        float $grandTotalDefault,
        float $grandTotalDisplay
    ): bool {
        try {
            return $order->update([
                'tax_amount' => $taxAmountDisplay,
                'grand_total' => $grandTotalDisplay,
                'default_tax_amount' => $taxAmountDefault,
                'default_grand_total' => $grandTotalDefault,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update order with tax', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get buyer fee percentage
     */
    public function getBuyerFeePercent(): float
    {
        try {
            $fee = $this->feeSettingsService->getActiveFee();

            return (float) ($fee->buyer_fee ?? 0);
        } catch (\Exception $e) {
            Log::error('Failed to get buyer fee', [
                'error' => $e->getMessage(),
            ]);

            return 0;
        }
    }
}
