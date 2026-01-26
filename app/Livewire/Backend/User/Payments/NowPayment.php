<?php

namespace App\Livewire\Backend\User\Payments;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\NowPaymentService;

#[Layout('frontend.layouts.app', ['title' => 'Now Payment'])]
class NowPayment extends Component
{
    public $priceAmount = 2000000000000000;
    public $priceCurrency = 'usd';
    public $payCurrency = 'btc';
    public $orderDescription = '';
    public $availableCurrencies = [];
    public $estimatedAmount = null;
    public $minimumAmount = 20;
    public $paymentDetails = null;
    public $loading = false;
    public $errorMessage = null;

    protected $rules = [
        'priceAmount' => 'required|numeric|min:1',
        'priceCurrency' => 'required|string',
        'payCurrency' => 'required|string',
        'orderDescription' => 'nullable|string|max:255',
    ];

    public function mount(NowPaymentService $nowPaymentService)
    {
        try {
            $currencies = $nowPaymentService->getAvailableCurrencies();
            $this->availableCurrencies = $currencies;

            // Load initial estimate
            $this->getEstimate();
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            session()->flash('error', $e->getMessage());
        }
    }

    public function updatedPriceAmount()
    {
        $this->getEstimate();
    }

    public function updatedPriceCurrency()
    {
        $this->getEstimate();
    }

    public function updatedPayCurrency()
    {
        $this->getEstimate();
    }

    public function getEstimate()
    {
        if ($this->priceAmount && $this->priceCurrency && $this->payCurrency) {
            try {
                $nowPaymentService = app(NowPaymentService::class);

                // Get estimate
                $estimate = $nowPaymentService->getEstimatedPrice(
                    (float) $this->priceAmount,
                    $this->priceCurrency,
                    $this->payCurrency
                );

                $this->estimatedAmount = $estimate['estimated_amount'] ?? null;

                // Get minimum amount
                $min = $nowPaymentService->getMinimumAmount(
                    $this->priceCurrency,
                    $this->payCurrency
                );

                $this->minimumAmount = $min;

                // Clear previous errors
                $this->errorMessage = null;

                // Validate minimum amount
                if ($this->estimatedAmount && $this->estimatedAmount < $this->minimumAmount) {
                    $this->errorMessage = "Amount is below minimum required: {$this->minimumAmount} " . strtoupper($this->payCurrency);
                }
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
                session()->flash('error', $e->getMessage());
            }
        }
    }

    // public function createPayment(NowPaymentService $nowPaymentService)
    // {
    //     $this->validate();

    //     // Check minimum amount before proceeding
    //     if ($this->estimatedAmount && $this->minimumAmount && $this->estimatedAmount < $this->minimumAmount) {
    //         session()->flash('error', "Amount is below minimum required: {$this->minimumAmount} " . strtoupper($this->payCurrency));
    //         return;
    //     }

    //     $this->loading = true;

    //     try {
    //         $result = $nowPaymentService->createPayment([
    //             'price_amount' => $this->priceAmount,
    //             'price_currency' => $this->priceCurrency,
    //             'pay_currency' => $this->payCurrency,
    //             'order_description' => $this->orderDescription ?: 'Cryptocurrency Payment',
    //             'order_id' => 'ORD-' . time() . '-' . auth()->id(),
    //             'success_url' => route('user.payment.success'),
    //             'cancel_url' => route('user.payment.cancel'),
    //         ]);

    //         if ($result['success']) {
    //             $this->paymentDetails = $result['payment'];
    //             session()->flash('success', 'Payment created successfully!');
    //             $this->errorMessage = null;
    //         } else {
    //             session()->flash('error', $result['message']);
    //             $this->errorMessage = $result['message'];
    //         }
    //     } catch (\Exception $e) {
    //         session()->flash('error', $e->getMessage());
    //         $this->errorMessage = $e->getMessage();
    //     } finally {
    //         $this->loading = false;
    //     }
    // }



    public function createPayment(NowPaymentService $nowPaymentService)
    {
        $this->validate();

        try {
            $invoice = $nowPaymentService->createInvoice([
                'price_amount' => $this->priceAmount,
                'price_currency' => $this->priceCurrency,
                'order_id' => 'ORD-' . time() . '-' . auth()->id(),
                'order_description' => $this->orderDescription ?: 'Cryptocurrency Payment',
                'ipn_callback_url' => 'https://nowpayments.io',
                'success_url' => route('user.payment.success'),
                'cancel_url' => route('user.payment.failed'),
            ]);

            return redirect()->away($invoice['invoice_url']);
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            session()->flash('error', $e->getMessage());
        }
    }


    public function resetPayment()
    {
        $this->paymentDetails = null;
        $this->errorMessage = null;
        $this->priceAmount = 2000000000000000;
        $this->orderDescription = '';
        session()->forget(['success', 'error']);
        $this->getEstimate();
    }

    public function render()
    {
        return view('livewire.backend.user.payments.now-payment');
    }
}
