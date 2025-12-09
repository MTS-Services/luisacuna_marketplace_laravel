<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

class PasswordChangeForm extends Form
{
   public string $password_old = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'password_old' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value,user()->password)) {
                        $fail(__('The old password is incorrect.'));
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S*$/',
                'different:password_old',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password_old.required' => __('Old password is required.'),
            'password.required' => __('New password is required.'),
            'password.min' => __('Password must be at least 8 characters long.'),
            'password.regex' => __('Password must contain uppercase, lowercase, and numbers without spaces.'),
            'password.different' => __('New password must be different from old password.'),
            'password.confirmed' => __('Password confirmation does not match.'),
            'password_confirmation.required' => __('Please confirm your new password.'),
        ];
    }
}
