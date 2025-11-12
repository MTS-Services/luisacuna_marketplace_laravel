<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GamePlatformStatus;
use App\Models\GamePlatform;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GamePlatformForm extends Form
{
    // 

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?string $status;

    public ?string $color_code_hex;

    public ?UploadedFile $icon = null;

    public ?string $icon_url = null;

    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:'.implode(',', array_column(GamePlatformStatus::cases(), 'value')),
            'icon' =>  'nullable|image|max:1024|dimensions:max_width=200,max_height=201',
            'color_code_hex' => 'nullable|string|regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/',
        ];
    }

    public function setData(GamePlatform $data) :void 
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->color_code_hex = $data->color_code_hex;
        $this->icon_url = $data->icon ?? null;
        
    }

    public function reset(...$properties):void {
        $this->name = null;
        $this->status = null;
        $this->id = null;
        $this->color_code_hex = null;
        $this->icon = null;
        $this->icon_url = null;
        $this->resetValidation();
    }

    public function fillables():array {
      return  array_filter([
            'name' => $this->name,
            'status' => $this->status,
            'color_code_hex' => $this->color_code_hex,
            'icon' => $this->icon,
      ], fn($value) => $value !== '' && $value !== null );
    }

    public function isUpdating():bool {
        return isset($this->id);
    }   
}
