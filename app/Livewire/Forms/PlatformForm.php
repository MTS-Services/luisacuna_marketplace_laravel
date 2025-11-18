<?php

namespace App\Livewire\Forms;

use App\Enums\PlatformStatus;
use App\Models\Platform;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class PlatformForm extends Form
{
    // 

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?string $status;

    public ?string $color;

    public ?UploadedFile $icon = null;

    public ?bool $remove_file = false;

    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:'.implode(',', array_column(PlatformStatus::cases(), 'value')),
            'icon' =>  'nullable|image|max:1024|dimensions:max_width=200,max_height=201',
            'color' => 'nullable|string|regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/',
            'remove_file' => 'nullable|boolean',
        ];
    }

    public function setData(Platform $data) :void 
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->color = $data->color;
        
    }

    public function reset(...$properties):void {
        $this->name = null;
        $this->status = PlatformStatus::ACTIVE->value;
        $this->id = null;
        $this->color = null;
        $this->icon = null;
        $this->remove_file = false;
        $this->resetValidation();
    }


    public function isUpdating():bool {
        return isset($this->id);
    }   
}
