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

    public ?string $first_name = '';

    public ?string $last_name = '';

    public ?string $username = null;

    public ?string $date_of_birth = '';

    public ?int $country_id = null;

    public ?int $language = null;

    public ?string $display_name = '';

    public ?string $email = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    public ?string $phone = '';

    public string $account_status;

    public ?string $reason = null;

    public ?int $currency_id = null;

    public ?UploadedFile $avatar = null;

    public bool $remove_avatar = false;

    public ?bool $remove_file = false;


    public ?string $originalAccountStatus = null;


    public function rules(): array
    {
        $reasonRule = $this->isAccountStatusChanged() ? 'required|string|max:500' : 'nullable|string|max:500';

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => $this->isUpdating() ? 'nullable|string|max:255|regex:/^[A-Za-z0-9_\-\$]+$/|unique:users,username,' . $this->user_id : 'required|string|max:255|unique:users,username|regex:/^[A-Za-z0-9_\-\$]+$/',
            // 'display_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'country_id' => 'required|exists:countries,id',
            'language' => 'required|max:255',
            'email' => 'required|email|max:255',
            'currency_id'   => 'required|exists:currencies,id',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'account_status' => 'required|string|in:' . implode(',', array_column(UserAccountStatus::cases(), 'value')),
            'reason' => $reasonRule,
            'avatar' => 'nullable|image|max:2048',
            // Track removed files
            'remove_file' => 'nullable|boolean',
        ];

        return $rules;
    }

    public function setData($user): void
    {
        $this->user_id = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username ?? null;
        // $this->display_name = $user->display_name;
        $this->country_id = $user->country_id;
        $this->language = $user->language_id;
        $this->date_of_birth = $user->date_of_birth;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->account_status = $user->account_status->value;
        $this->originalAccountStatus = $user->account_status->value;
        $this->currency_id = $user->currency_id;
        $this->reason = null;
    }

    public function reset(...$properties): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->username = '';
        // $this->display_name = '';
        $this->country_id = '';
        $this->date_of_birth = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->account_status = UserAccountStatus::ACTIVE->value;
        $this->originalAccountStatus = null;
        $this->reason = null;
        $this->avatar = null;
        $this->remove_avatar = false;
        $this->currency_id = null;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->user_id);
    }

    // protected function isAccountStatusChanged(): bool
    // {
    //     // Update user account_status change  check if account_status was changed
    //     return $this->isUpdating() &&
    //         $this->originalAccountStatus !== null &&
    //         $this->originalAccountStatus !== $this->account_status;
    // }

    // Public helper method - Blade এ ব্যবহার করার জন্য
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
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            // 'display_name',
            'date_of_birth' => $this->date_of_birth,
            'country_id' => $this->country_id,
            'language_id' => $this->language,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'account_status' => $this->account_status,
            'avatar'    => $this->avatar,
            'currency_id' => $this->currency_id,
        ];
        if ($this->isAccountStatusChanged() && $this->reason) {
            $data['reason'] = $this->reason;
        }
    }
}
