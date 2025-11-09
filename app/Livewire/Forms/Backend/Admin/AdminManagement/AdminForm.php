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
    public ?string $address = '';
    public string $status = '';
    public ?string $avatar = null;
    public bool $remove_avatar = false;


    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(AdminStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
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
        $this->address = $data->address;
        $this->status = $data->status->value;
        // $this->avatar = $data->avatar;

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
        $this->address = '';
        $this->status = AdminStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_avatar = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
