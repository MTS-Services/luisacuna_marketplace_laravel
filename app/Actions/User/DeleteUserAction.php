<?php

namespace App\Actions\User;

use App\Models\User;
use App\Services\User\UserService;

class DeleteUserAction
{
    public function __construct(protected UserService $userService) {}

    public function execute($id): bool
    {
        return $this->userService->deleteUser($id);
    }
}
