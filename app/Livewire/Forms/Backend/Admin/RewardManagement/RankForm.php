<?php

namespace App\Livewire\Forms\Backend\Admin\RewardManagement;

use Livewire\Form;
use App\Models\Rank;
use App\Enums\RankStatus;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

class RankForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $name = '';
    public string $slug = '';

    public ?int $minimum_points = null;
    public ?int $maximum_points = null;


    public string $icon = '';
    public string $status = RankStatus::ACTIVE->value;
    public bool $initial_assign = false;



    /**
     * Validation rules (handles create/update logic)
     */

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:ranks,name,' . $this->id,
            'slug' => 'required|string|max:255|unique:ranks,slug,' . $this->id,
            'minimum_points' => 'required|integer',
            'maximum_points' => 'nullable|integer',
            'icon' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(RankStatus::cases(), 'value')),
            'initial_assign' => 'required|boolean',
        ];
    }

    /**
     * Fill the form fields from a Language model
     */


    public function setData(Rank $data): void
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->slug = $data->slug;
        $this->minimum_points = $data->minimum_points;
        $this->maximum_points = $data->maximum_points;
        $this->icon = $data->icon;
        $this->status = $data->status->value;
        $this->initial_assign = $data->initial_assign;
    }



    /**
     * Reset form fields
     */

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->slug = '';
        $this->minimum_points = null;
        $this->maximum_points = null;
        $this->icon = '';
        $this->status = RankStatus::ACTIVE->value;
        $this->initial_assign = false;
    }
}
