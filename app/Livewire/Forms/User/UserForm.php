<?php

namespace App\Livewire\Forms\User;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use App\Enums\UserAccountStatus;
use Illuminate\Http\UploadedFile;

class UserForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public ?UploadedFile $avatar = null;
    public ?string $description = '';
    public ?string $first_name = '';
    public ?string $last_name = '';
    public ?string $email = '';
    public ?string $username = '';
    public ?string $phone = null;
    public $account_status = UserAccountStatus::PENDING_VERIFICATION->value;
    public ?string $password = '';
    public ?string $password_confirmation = '';
    public ?bool $remove_avatar = false;
    public ?bool $remove_file = false;
    public ?int $country_id = null;
    public ?string $date_of_birth = null;

    /**
     * Define validation rules for user update
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'country_id' => 'sometimes|required|exists:countries,id',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->id),
            ],
            'password' => $this->isUpdating()
                ? 'nullable|string|min:8'
                : 'required|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'avatar' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date', // Validation rule for date_of_birth
            'phone' => 'nullable|string|max:20',
            'account_status' => 'sometimes|required|string|in:' . implode(',', array_column(UserAccountStatus::cases(), 'value')),
        ];
    }

    /**
     * Prefill form data for editing
     */
    public function setData($user): void
    {
        $this->id = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->description = $user->description;
        $this->country_id = $user->country_id;
        $this->date_of_birth = $user->date_of_birth;
        $this->phone = $user->phone;
        $this->account_status = $user->account_status->value;
    }

    /**
     * Reset form state
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->avatar = null;
        $this->description = '';
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->username = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->remove_avatar = false;
        $this->remove_file = false;
        $this->date_of_birth = null; // Reset date_of_birth field
        $this->phone = null;
        $this->account_status = UserAccountStatus::PENDING_VERIFICATION->value;

        $this->resetValidation();
    }

    /**
     * Detect if user is updating
     */
    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
