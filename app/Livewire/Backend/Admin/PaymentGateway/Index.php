<?php

namespace App\Livewire\Backend\Admin\PaymentGateway;

use App\Models\PaymentGateway;
use Livewire\Component;

class Index extends Component
{
    public function toggleActive(int $gatewayId): void
    {
        $gateway = PaymentGateway::findOrFail($gatewayId);
        $gateway->update([
            'is_active' => ! $gateway->is_active,
            'updated_by' => admin()->id,
        ]);

        $status = $gateway->is_active ? 'activated' : 'deactivated';
        $this->dispatch('notify', type: 'success', message: __(':name gateway :status.', ['name' => $gateway->name, 'status' => $status]));
    }

    public function render()
    {
        return view('livewire.backend.admin.payment-gateway.index', [
            'gateways' => PaymentGateway::orderBy('sort_order')->get(),
        ]);
    }
}
