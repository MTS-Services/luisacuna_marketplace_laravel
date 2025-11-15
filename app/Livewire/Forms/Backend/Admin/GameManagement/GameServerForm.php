<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;


use App\Enums\GameServerStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GameServerForm extends Form
{


    #[Locked]
    public ?int $id = null;


    public string $name = '';
    public ?string $status = '';
    public ?UploadedFile $icon = null;


    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(GameServerStatus::cases(), 'value')),
            'icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        // $this->avatar = $data->avatar;

    }

    public function reset(...$properties): void
    {
        $this->id = null;

        $this->name = '';

        $this->status = GameServerStatus::ACTIVE->value;


        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
