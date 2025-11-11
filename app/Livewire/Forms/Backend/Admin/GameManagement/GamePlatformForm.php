<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GamePlatformStatus;
use App\Models\GamePlatform;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GamePlatformForm extends Form
{
    // 

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?string $status;


    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:'.implode(',', array_column(GamePlatformStatus::cases(), 'value')),
        ];
    }

    public function setData(GamePlatform $data) :void 
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        
    }

    public function reset(...$properties):void {
        $this->name = null;
        $this->status = null;
        $this->id = null;
        $this->resetValidation();
    }

    public function fillables():array {
      return  [
            'name' => $this->name,
            'status' => $this->status,
      ];
    }

    public function isUpdating():bool {
        return isset($this->id);
    }   
}
