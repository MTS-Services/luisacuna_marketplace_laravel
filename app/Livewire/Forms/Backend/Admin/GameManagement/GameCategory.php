<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory as ModelsGameCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GameCategory extends Form
{
    //
    ## Attributes
    #[Validate('required', 'string')]
    public ?string $name = null;
    #[Validate('string')]
    public ?string $description = null;
    #[Validate('required', 'string',)]
    public ?string $status = null;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(GameCategoryStatus::cases(), 'value')),
        ];

    }

    public function setCategory(ModelsGameCategory $category){
        
        $this->name = $category->name;
        $this->description = $category->description;
        $this->status = $category->status;
    }

}
