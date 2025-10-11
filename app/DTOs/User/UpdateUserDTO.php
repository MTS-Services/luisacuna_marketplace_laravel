<?php

namespace App\DTOs\User;

use App\Enums\UserStatus;
use Illuminate\Http\UploadedFile;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?UserStatus $status = null,
        public readonly ?UploadedFile $avatar = null,
        public readonly bool $removeAvatar = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            status: isset($data['status']) ? UserStatus::from($data['status']) : null,
            avatar: $data['avatar'] ?? null,
            removeAvatar: $data['remove_avatar'] ?? false,
        );
    }

    public static function fromRequest($request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->status) {
            $data['status'] = $this->status->value;
        }

        return $data;
    }
}