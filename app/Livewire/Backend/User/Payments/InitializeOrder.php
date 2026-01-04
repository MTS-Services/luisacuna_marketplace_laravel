<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use App\Traits\Livewire\WithNotification;

class InitializeOrder extends Component
{
    use WithNotification;

    public ?Product $product = null;
    public int $quantity = 1;

    protected OrderService $orderService;

    protected ProductService $productService;
    public function boot(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    public function mount($productId)
    {
        $this->product= $this->productService->findData(decrypt($productId));
        // $this->product = Product::where('id', decrypt($productId))->first();
        $this->product->load(['user.seller', 'platform', 'product_configs.game_configs']);
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

    public function submit()
    {
        $token = bin2hex(random_bytes(126));

        $order = $this->orderService->createData([
            'order_id' => generate_order_id_hybrid(),
            'user_id' => user()->id,
            'source_id' => $this->product->id,
            'source_type' => Product::class,
            'unit_price' => $this->product->price,
            'total_amount' => $this->product->price * $this->quantity,
            'tax_amount' => 0,
            'grand_total' => ($this->product->price * $this->quantity),
            'quantity' => $this->quantity,
            'currency' => 'USD',
            'creater_id' => user()->id,
            'creater_type' => User::class,
        ]);

        Session::driver('redis')->put("checkout_{$token}", [
            'order_id' => $order->id,
            'price_locked' => ($this->product->price * $this->quantity),
            'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
        ]);

        return $this->redirect(
            route('user.checkout', ['slug' => encrypt($this->product->id), 'token' => $token]),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.backend.user.payments.initialize-order');
    }
}
