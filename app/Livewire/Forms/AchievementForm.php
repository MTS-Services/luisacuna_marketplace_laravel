<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Locked;
use App\Enums\AchievementStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;

class AchievementForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?int $rank_id = null;
    public ?int $achievement_type_id = null;

    public ?string $title = null;
    public ?string $description = null;

    public ?int $target_value = null;
    public ?int $point_reward = null;
    public ?string $status = AchievementStatus::ACTIVE->value;

    public ?UploadedFile $icon = null;
    public bool $remove_icon = false;


    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        return [
            'rank_id' => 'required|integer|exists:ranks,id',
            'achievement_type_id' => 'required|integer|exists:achievement_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', 
            'remove_icon' => 'boolean', 
            'target_value' => 'required|integer',
            'point_reward' => 'required|integer',
            'status' => 'required|string|in:' . implode(',', array_column(AchievementStatus::cases(), 'value')),
        ];
    }

    /**
     * Fill the form fields from a Language model
     */

    public function setData($data)
    {
        $this->id = $data->id;
        $this->rank_id = $data->rank_id;
        $this->achievement_type_id = $data->achievement_type_id;
        $this->title = $data->title;
        $this->description = $data->description;
        // $this->icon = $data->icon ?? '';
        $this->remove_icon = false;
        $this->target_value = $data->target_value;
        $this->point_reward = $data->point_reward;
        $this->status = $data->status->value;
    }
    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->rank_id = null;
        $this->achievement_type_id = null;
        $this->title = null;
        $this->description = null;
        $this->icon = null;
        $this->target_value = null;
        $this->point_reward = null;
        $this->status = AchievementStatus::ACTIVE->value;
    }
}
