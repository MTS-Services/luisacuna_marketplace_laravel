<?php

namespace App\Livewire;

use App\Models\DeliveryInfo as DeliveryInfoModel;
use Livewire\Attributes\On;
use Livewire\Component;
use Flux\Flux;

class DeliveryInfo extends Component
{
    public int $productId = 0;

    public bool $is_gifting = false;

    public string $notes = '';

    public string $email = '';

    public string $username = '';

    #[On('open-delivery-modal')]
    public function openModal(int $productId): void
    {
        $this->productId  = $productId;
        $this->is_gifting = false;
        $this->reset(['notes', 'email', 'username']);
        $this->resetErrorBag();

        Flux::modal('delivery-info')->show();
    }

    public function submit(): void
    {
        $this->validate([
            'is_gifting' => ['boolean'],
            'notes'      => ['nullable', 'string', 'max:1000'],
            'email'      => ['required', 'email', 'max:255'],
            'username'   => ['required', 'string', 'max:255'],
        ]);

        $deliveryInfo = DeliveryInfoModel::create([
            'user_id'    => user()->id,
            'product_id' => $this->productId,
            'email'      => $this->email,
            'username'   => $this->username,
            'is_gifting' => $this->is_gifting,
            'notes'      => $this->notes ?: null,
        ]);

        Flux::modal('delivery-info')->close();

        $this->reset(['notes', 'email', 'username', 'is_gifting']);

        $this->dispatch('delivery-info-saved',
            deliveryInfoId: $deliveryInfo->id,
            productId: $this->productId,
        );
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.delivery-info');
    }
}