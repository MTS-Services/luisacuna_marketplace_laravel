<?php

namespace App\Actions\User;

use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Services\User\UserService;

class UpdateUserAction
{
    public function __construct(protected UserService $userService) {}

    public function execute(int $id, UpdateUserDTO $dto): User
    {
        return $this->userService->updateUser($id, $dto);
    }
}
