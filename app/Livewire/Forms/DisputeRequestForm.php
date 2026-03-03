<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DisputeRequestForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $reason_category = '';

    #[Validate('required|string|min:10|max:2000')]
    public string $description = '';
}
