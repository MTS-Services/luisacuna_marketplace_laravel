<?php

namespace App\Livewire\Forms;

use App\Models\Hero;
use Livewire\Attributes\Locked;
use Livewire\Form;

class BannerForm extends Form
{
    #[Locked]
    public ?int $id = null;
    public ?string $title = null;
    public ?string $content = null;
    public ?string $action_title = null;
    public ?string $action_url = null;
    public ?string $target = null;
    public ?string $status = null;
    public $image = null;
    public $remove_file = false;

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:1000',
            'action_title' => 'nullable|string|max:255',
            'action_url' => 'nullable|url|max:255',
            'target' => 'nullable|string|in:_self,_blank',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|image|max:10240', // Max 10MB
            'remove_file' => 'nullable|boolean',
        ];
    }

    public function setData(Hero $data){
        $this->id = $data->id ?? null;
        $this->title = $data->title ?? null;
        $this->content = $data->content ?? null;
        $this->action_title = $data->action_title ?? null;
        $this->action_url = $data->action_url ?? null;
        $this->target = $data->target ?? null;
        $this->status = $data->status->value ?? null;
        $this->remove_file = false;
    }

  public function reset(...$properties): void
    {
        $this->id = null;
        $this->title = null;
        $this->content = null;
        $this->action_title = null;
        $this->action_url = null;
        $this->target = null;
        $this->status = null;
        $this->image = null;
        $this->remove_file = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
