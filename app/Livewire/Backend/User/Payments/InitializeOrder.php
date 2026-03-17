<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\ActiveInactiveEnum;
use App\Enums\FeedbackType;
use App\Models\Product;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\FeedbackService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class InitializeOrder extends Component
{
    use WithNotification;

    public ?Product $product = null;

    public int $quantity = 1;

    public $feedbacks;

    public $product_id;

    public $positiveFeedbacksCount;

    public $negativeFeedbacksCount;

    // Display currency properties
    public string $displayCurrency;

    public string $displaySymbol;

    public float $exchangeRate;

    // ------------------------------------------------------------------
    // Pending order payload — populated in submit(), consumed in
    // finalizeOrder() after the DeliveryInfo modal is submitted.
    // ------------------------------------------------------------------
    protected array $pendingOrderPayload = [];

    protected OrderService $orderService;

    protected ProductService $productService;

    protected FeedbackService $feedbackService;

    protected CurrencyService $currencyService;

    public function boot(
        OrderService $orderService,
        ProductService $productService,
        FeedbackService $feedbackService,
        CurrencyService $currencyService
    ) {
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->feedbackService = $feedbackService;
        $this->currencyService = $currencyService;
        $this->feedbacks = collect([]);
    }

    public function mount($productId)
    {
        $this->product = $this->productService->findData(decrypt($productId));
        $this->product->load(['user.seller', 'user.feedbacksReceived', 'platform', 'product_configs.game_configs', 'orders.feedbacks']);
        $this->feedbacks = $this->product->feedbacks()->latest()->take(6)->get();

        $currentCurrency = $this->currencyService->getCurrentCurrency();
        $this->displayCurrency = $currentCurrency->code;
        $this->displaySymbol = $currentCurrency->symbol;
        $this->exchangeRate = $currentCurrency->exchange_rate;

        $this->positiveFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();
    }

    public function updatedQuantity()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        if ($this->product && $this->quantity > $this->product->quantity) {
            $this->quantity = $this->product->quantity;
        }
    }

    // ------------------------------------------------------------------
    // STEP 1 — Called by the "Buy Now" button.
    //
    //   • Validates the product is still purchasable.
    //   • Pre-computes all currency amounts and stashes them in the
    //     session so they survive across Livewire requests.
    //   • Dispatches the 'open-delivery-modal' event which the sibling
    //     DeliveryInfo component is listening for.
    // ------------------------------------------------------------------
    public function submit()
    {
        if ($this->product) {
            $this->product->refresh();
        }

        // AFTER
        if (!$this->product || $this->product->status?->value !== ActiveInactiveEnum::ACTIVE->value) {
            $this->addError('order', __('This product is no longer available.'));
            return null;
        }

        // Backend guard — prevent purchasing own product even if frontend is bypassed
        if ((int) $this->product->user_id === (int) user()->id) {
            $this->addError('order', __('You cannot purchase your own product.'));
            return null;
        }

        try {
            $defaultCurrency = $this->currencyService->getDefaultCurrency();

            // --- DEFAULT CURRENCY (stored) ---
            $unitPriceDefault  = (float) $this->product->price;
            $quantity          = (int) $this->quantity;
            $totalAmountDefault = $unitPriceDefault * $quantity;
            $taxAmountDefault  = 0;
            $grandTotalDefault = $totalAmountDefault;

            // --- DISPLAY CURRENCY (shown to user) ---
            $unitPriceDisplay    = $this->currencyService->convertFromDefault($unitPriceDefault, $this->displayCurrency);
            $totalAmountDisplay  = $this->currencyService->convertFromDefault($totalAmountDefault, $this->displayCurrency);
            $taxAmountDisplay    = $this->currencyService->convertFromDefault($taxAmountDefault, $this->displayCurrency);
            $grandTotalDisplay   = $this->currencyService->convertFromDefault($grandTotalDefault, $this->displayCurrency);

            $token   = bin2hex(random_bytes(126));
            $orderId = generate_order_id_hybrid();

            // Stash the fully-computed payload so finalizeOrder() can
            // pick it up without re-doing all the math.
            Session::put("pending_order_{$this->product->id}", [
                'order_id'              => $orderId,
                'token'                 => $token,
                'user_id'               => user()->id,
                'source_id'             => $this->product->id,
                'source_type'           => Product::class,

                // Display amounts
                'unit_price'            => $unitPriceDisplay,
                'total_amount'          => $totalAmountDisplay,
                'tax_amount'            => $taxAmountDisplay,
                'grand_total'           => $grandTotalDisplay,
                'currency'              => $this->displayCurrency,
                'display_currency'      => $this->displayCurrency,

                // Default amounts
                'default_unit_price'    => $unitPriceDefault,
                'default_total_amount'  => $totalAmountDefault,
                'default_tax_amount'    => $taxAmountDefault,
                'default_grand_total'   => $grandTotalDefault,
                'default_currency'      => $defaultCurrency->code,

                // Meta
                'exchange_rate'         => $this->exchangeRate,
                'quantity'              => $quantity,
                'display_symbol'        => $this->displaySymbol,
                'points'                => $totalAmountDefault * env('ORDER_POINTS_MULTIPLAYER', 100),
                'notes'                 => 'Order initiated by ' . user()->username . ', Order ID: ' . $orderId,
                'creater_id'            => user()->id,
                'creater_type'          => User::class,
            ]);

            // Tell the DeliveryInfo component to open its modal.
            $this->dispatch('open-delivery-modal', productId: $this->product->id);
        } catch (\Exception $e) {
            Log::error('Order pre-computation failed', [
                'product_id' => $this->product->id,
                'user_id'    => user()->id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            $this->addError('order', __('Failed to initialize order. Please try again.'));
        }

        return null;
    }

    // ------------------------------------------------------------------
    // STEP 2 — Called automatically when DeliveryInfo dispatches
    //          'delivery-info-saved' after the modal is submitted.
    //
    //   • Retrieves the pre-computed payload from the session.
    //   • Creates the Order record linked to the DeliveryInfo record.
    //   • Stores the checkout session and redirects.
    // ------------------------------------------------------------------
    #[On('delivery-info-saved')]
    public function finalizeOrder(int $deliveryInfoId, int $productId): mixed
    {
        $payload = Session::pull("pending_order_{$productId}");

        if (! $payload) {
            $this->addError('order', __('Order session expired. Please try again.'));

            return null;
        }

        // Guard: make sure this event is for the product THIS component manages.
        if ((int) $payload['source_id'] !== (int) $productId) {
            return null;
        }

        try {
            $order = $this->orderService->createData(array_merge($payload, [
                'delivery_info_id' => $deliveryInfoId,
            ]));

            Session::driver('database')->put("checkout_{$payload['token']}", [
                'order_id'          => $order->id,
                'subtotal_locked'   => $payload['default_total_amount'],
                'price_locked'      => $payload['default_total_amount'],
                'display_subtotal'  => $payload['total_amount'],
                'display_currency'  => $payload['display_currency'],
                'exchange_rate'     => $payload['exchange_rate'],
                'expires_at'        => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
            ]);

            Log::info('Order finalized with delivery info', [
                'order_id'         => $payload['order_id'],
                'delivery_info_id' => $deliveryInfoId,
                'user_id'          => user()->id,
                'product_id'       => $productId,
            ]);

            return $this->redirect(
                route('user.checkout', ['slug' => encrypt($productId), 'token' => $payload['token']]),
                navigate: true
            );
        } catch (\Exception $e) {
            Log::error('Order finalization failed', [
                'product_id'       => $productId,
                'delivery_info_id' => $deliveryInfoId,
                'user_id'          => user()->id,
                'error'            => $e->getMessage(),
                'trace'            => $e->getTraceAsString(),
            ]);

            $this->addError('order', __('Failed to create order. Please try again.'));

            return null;
        }
    }

    public function getDisplayPrice(): float
    {
        return $this->currencyService->convertFromDefault(
            $this->product->price * $this->quantity,
            $this->displayCurrency
        );
    }

    public function getFormattedTotal(): string
    {
        $total = $this->getDisplayPrice();

        return $this->displaySymbol . number_format($total, 2);
    }

    public function render()
    {
        return view('livewire.backend.user.payments.initialize-order');
    }
}
