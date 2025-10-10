<?php

namespace App\DTOs\User;

use App\Enums\UserStatus;

readonly class UpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $phone = null,
        public ?UserStatus $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: isset($data['password']) && $data['password'] ? bcrypt($data['password']) : null,
            phone: $data['phone'] ?? null,
            status: isset($data['status']) ? UserStatus::from($data['status']) : null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = $this->password;
        }

        if ($this->status) {
            $data['status'] = $this->status->value;
        }

        return array_filter($data, fn($value) => $value !== null);
    }
}
