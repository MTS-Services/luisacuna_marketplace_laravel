<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use App\Models\Product;
use Livewire\Component;

class Details extends Component
{
    // Livewire Component
    public Product $data;

    public function mount($productId): void
    {
        $this->data = Product::findOrFail($productId)
            ->with('user', 'category', 'platform', 'games', 'game')
            ->findOrFail($productId);

            // dd($this->data);

    }

    public function render()
    {
        return view('livewire.backend.admin.product-management.category.details');
    }
}
