<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\URL;

class Detail extends Component
{
    public Order $data;
    public ?string $backUrl = null;

    public function mount(Order $data): void
    {
        $this->data = $data;
        $this->data->load(['user', 'source.user', 'source.game', 'transactions']);

        // Capture previous URL, fallback to the default route if no referrer exists
        $this->backUrl = url()->previous() !== url()->current()
            ? url()->previous()
            : route('admin.gm.category.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.detail');
    }
}
