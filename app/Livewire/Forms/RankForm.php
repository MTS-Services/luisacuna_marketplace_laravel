<?php
 
namespace App\Livewire\Forms;
 

use Livewire\Form;
use App\Models\Rank;
use App\Enums\RankStatus;
use App\Rules\PointRange;
use Livewire\Attributes\Locked;
 
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
 
    public bool $remove_icon = false;
 
    /**
     * Get the validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:ranks,name,' . ($this->id ?? 'NULL'),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:ranks,slug,' . ($this->id ?? 'NULL'),
            ],
            'minimum_points' => [
                'required',
                'integer',
                'min:0',
            ],
            'maximum_points' => [
                'nullable',
                'integer',
                'min:0',
                'gte:minimum_points',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:500',
            ],
            'remove_icon' => [
                'nullable',
                'boolean',
            ],
            'status' => [
                'required',
                'string',
                'in:' . implode(',', array_column(RankStatus::cases(), 'value')),
            ],
        ];
 
        // Add range overlap validation only if points are provided
        if ($this->minimum_points !== null) {
            $rules['minimum_points'][] = new PointRange(
                $this->minimum_points,
                $this->maximum_points ?? PHP_INT_MAX,
                $this->id
            );
        }
 
        return $rules;
    }
 
    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The rank name is required.',
            'name.unique' => 'This rank name is already in use.',
            'slug.required' => 'The slug is required.',
            'slug.unique' => 'This slug is already in use.',
            'slug.regex' => 'The slug must be lowercase with hyphens (e.g., "bronze-tier").',
            'minimum_points.required' => 'The minimum points value is required.',
            'minimum_points.min' => 'The minimum points must be at least 0.',
            'maximum_points.min' => 'The maximum points must be at least 0.',
            'maximum_points.gte' => 'The maximum points must be greater than or equal to the minimum points.',
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
 
    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function validationAttributes(): array
    {
        return [
            'name' => 'rank name',
            'slug' => 'slug',
            'minimum_points' => 'minimum points',
            'maximum_points' => 'maximum points',
            'icon' => 'icon',
            'status' => 'status',
        ];
    }
 
    /**
     * Set the rank data for editing.
     *
     * @param \App\Models\Rank $rank
     * @return void
     */
    public function setData(Rank $rank): void
    {
        $this->id = $rank->id;
        $this->name = $rank->name;
        $this->slug = $rank->slug;
        $this->minimum_points = $rank->minimum_points;
        $this->maximum_points = $rank->maximum_points;
        $this->icon = $rank->icon ?? '';
        $this->remove_icon = false;
        $this->status = $rank->status->value ?? RankStatus::ACTIVE->value;
    }
 
    /**
     * Get all form data as an array for service layer.
     *
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'minimum_points' => $this->minimum_points,
            'maximum_points' => $this->maximum_points,
             'icon' => $this->icon ?: null,
            'status' => $this->status,
            'initial_assign' => $this->initial_assign,
        ];
    }
 
    /**
     * Reset the form to its initial state.
     *
     * @return void
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
 
        $this->resetValidation();
    }
 
    /**
     * Check if the form is in update mode.
     *
     * @return bool
     */
    public function isUpdating(): bool
    {
        return !empty($this->id);
    }
}