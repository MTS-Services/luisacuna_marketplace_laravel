<?php

namespace App\DTOs\User;

use App\Enums\UserStatus;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $phone = null,
        public UserStatus $status = UserStatus::Active,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: bcrypt($data['password']),
            phone: $data['phone'] ?? null,
            status: $data['status'] ?? UserStatus::Active,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'status' => $this->status,
        ];
    }
}
