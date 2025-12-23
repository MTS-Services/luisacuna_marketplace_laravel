<?php

namespace App\Livewire\Test;

use App\Models\Order;
use App\Models\TestItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Items extends Component
{

    public Collection $items;

    public function mount()
    {
        $this->items = TestItem::all();
    }

    public function render()
    {

        return view('livewire.test.items');
    }

    public function buyNow($encryptedSlug)
    {
        $item = TestItem::where('slug', decrypt($encryptedSlug))->first();
        $token = bin2hex(random_bytes(126));
        $order = Order::create([
            'order_id' => generate_order_id_hybrid(),
            'user_id' => user()->id,
            'source_id' => $item->id,
            'source_type' => TestItem::class,
            'total_amount' => $item->price,
            'tax_amount' => 0,
            'grand_total' => $item->price,
        ]);
        Session::driver('redis')->put("checkout_{$token}", [
            'order_id' => $order->id,
            'price_locked' => $item->price,
            'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
        ]);
        return $this->redirect(
            route('checkout', ['slug' => $item->slug, 'token' => $token]),
            navigate: true
        );
    }
}
