<?php

namespace App\Livewire\Forms;
use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Models\Faq;
use Livewire\Attributes\Locked;
use Livewire\Form;

class FaqForm extends Form
{
    //

    #[Locked]

    public ?int $id = null;

    public ?string $question = null;

    public ?string $answer = null;

    public string $status = FaqStatus::ACTIVE->value;

    public string $type = FaqType::BUYER->value;



    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|string',
            'type' => 'required|string',
        ];
    }

    public function setData(Faq $data): void
    {

        $this->status = $data->status->value;
        $this->answer = $data->answer;
        $this->question = $data->question;
        $this->type = $data->type->value;

    }

    public function reset(...$properties): void
    {
        $this->question = null;
        $this->answer = null;
        $this->type = FaqType::BUYER->value;
        $this->status = FaqStatus::ACTIVE->value;


        $this->resetValidation();
    }


    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
