<?php

namespace App\Livewire\Forms\Backend\Admin\AdminManagement;

use App\Enums\AdminStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class AdminForm extends Form
{


    #[Locked]
    public ?int $id = null;
    public ?int $role_id = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?string $password_confirmation = '';
    public ?string $phone = '';
    public string $status = AdminStatus::ACTIVE->value;
    public ?UploadedFile $avatar = null;
    public $avatars = null;

    // Track removed files
    public bool $remove_file = false;
    public array $removed_files = [];


    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|string|in:' . implode(',', array_column(AdminStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048|dimensions:max_width=300,max_height=300',
            'avatars' => 'nullable|array',
            'avatars.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Track removed files
            'remove_file' => 'nullable|boolean',
            'removed_files' => 'nullable|array',
            'removed_files.*' => 'nullable|string',
        ];

        return $rules;
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->role_id = $data->role_id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->status = $data->status->value;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->role_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->status = AdminStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_file = false;
        $this->removed_files = [];
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
