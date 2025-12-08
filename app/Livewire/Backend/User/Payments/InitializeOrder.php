<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\Currency;
use App\Models\Product;
use Livewire\Component;

class InitializeOrder extends Component
{

    public ?Product $product = null;
    public int $quantity = 1;

    public function mount($productId)
    {
        $this->product = Product::where('id', decrypt($productId))->first();
    }

    public function updatedQuantity()
    {
        // Prevent invalid quantity
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        if ($this->product && $this->quantity > $this->product->quantity) {
            $this->quantity = $this->product->quantity;
        }
    }

    public function submit()
    {
        dd($this->product, $this->quantity);
    }

    public function render()
    {
        return view('livewire.backend.user.payments.initialize-order');
    }
}
