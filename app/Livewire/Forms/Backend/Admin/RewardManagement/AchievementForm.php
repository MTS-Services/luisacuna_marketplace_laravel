<?php

namespace App\Livewire\Forms\Backend\Admin\RewardManagement;

use Livewire\Form;
use Livewire\Attributes\Locked;
use App\Enums\AchievementStatus;
use Livewire\Attributes\Validate;

class AchievementForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?int $rank_id = null;
    public ?int $category_id = null;

    public ?string $title = null;
    public ?string $description = null;
    public ?string $icon = null;

    public ?int $target_value = null;
    public ?int $point_reward = null;
    public ?string $status = AchievementStatus::ACTIVE->value;


    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        return [
            'rank_id' => 'required|integer|exists:ranks,id',
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
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
        $this->category_id = $data->category_id;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->icon = $data->icon;
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
        $this->category_id = null;
        $this->title = null;
        $this->description = null;
        $this->icon = null;
        $this->target_value = null;
        $this->point_reward = null;
        $this->status = AchievementStatus::ACTIVE->value;
    }
}
