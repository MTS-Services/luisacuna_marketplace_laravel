<?php

namespace App\Livewire\Forms\Backend\Admin\UserManagement;

use Livewire\Form;
use App\Enums\UserAccountStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;

class UserForm extends Form
{
    #[Locked]
    public ?int $user_id = null;

    public string $first_name = '';
    public string $last_name = '';
    public string $username = '';
    public string $date_of_birth = '';
    public string $display_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $phone = '';
    public string $account_status = '';
    public ?string $reason = null;
    public string $description = '';

    public ?UploadedFile $avatar = null;
    public $avatars = null;

    // Track removed files
    public bool $remove_file = false;
    public array $removed_files = [];

    public ?string $originalAccountStatus = null;

    public function rules(): array
    {
        $reasonRule = $this->isAccountStatusChanged() ? 'required|string|max:500' : 'nullable|string|max:500';

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => $this->isUpdating() 
                ? 'required|string|max:255|regex:/^[A-Za-z0-9_\-\$]+$/|unique:users,username,' . $this->user_id 
                : 'required|string|max:255|unique:users,username|regex:/^[A-Za-z0-9_\-\$]+$/',
            'date_of_birth' => 'nullable|date',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'account_status' => 'required|string|in:' . implode(',', array_column(UserAccountStatus::cases(), 'value')),
            'reason' => $reasonRule,
            'avatar' => 'nullable|image|max:2048|dimensions:max_width=300,max_height=300',
            'remove_file' => 'nullable|boolean',
            'description' => 'nullable|string|max:500',
        ];

        return $rules;
    }

    public function setData($user): void
    {
        $this->user_id = $user->id;
        $this->first_name = $user->first_name ?? '';
        $this->last_name = $user->last_name ?? '';
        $this->username = $user->username ?? '';
        $this->date_of_birth = $user->date_of_birth ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->account_status = $user->account_status->value ?? UserAccountStatus::ACTIVE->value;
        $this->originalAccountStatus = $user->account_status->value ?? UserAccountStatus::ACTIVE->value;
        $this->reason = null;
        $this->description = $user->description ?? '';
    }

    public function reset(...$properties): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->username = '';
        $this->description = '';
        $this->date_of_birth = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->account_status = UserAccountStatus::ACTIVE->value;
        $this->originalAccountStatus = null;
        $this->reason = null;
        $this->avatar = null;
        $this->remove_file = false;
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->user_id);
    }

    public function shouldShowReasonField(): bool
    {
        return $this->isAccountStatusChanged();
    }

    private function isAccountStatusChanged(): bool
    {
        return $this->isUpdating() &&
            $this->originalAccountStatus !== null &&
            $this->originalAccountStatus !== $this->account_status;
    }

    public function fillables(): array
    {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'date_of_birth' => $this->date_of_birth,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'account_status' => $this->account_status,
            'avatar' => $this->avatar,
        ];

        if ($this->isAccountStatusChanged() && $this->reason) {
            $data['reason'] = $this->reason;
        }

        return $data;
    }

    public function all(): array
    {
        return [
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'description' => $this->description,
            'account_status' => $this->account_status,
        ];
    }
}