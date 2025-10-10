<?php

namespace App\Actions\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User;
use App\Services\User\UserService;

class CreateUserAction
{
    public function __construct(protected UserService $userService) {}

    public function execute(CreateUserDTO $dto): User
    {
        return $this->userService->createUser($dto);
    }
}
