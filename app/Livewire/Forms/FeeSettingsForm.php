<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

class FeeSettingsForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?string $seller_fee = null;
    public ?string $buyer_fee = null;

    public function rules(): array
    {
        return [
            'seller_fee' => 'required|numeric|min:0',
            'buyer_fee'  => 'required|numeric|min:0',
        ];
    }

    public function setData($data): void
    {
        $this->id = $data->id ?? null;
        $this->seller_fee = $data->seller_fee ?? null;
        $this->buyer_fee = $data->buyer_fee ?? null;
    }

    public function reset(...$properties): void
    {
        $this->seller_fee = null;
        $this->buyer_fee = null;
        $this->resetValidation();
    }

    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
