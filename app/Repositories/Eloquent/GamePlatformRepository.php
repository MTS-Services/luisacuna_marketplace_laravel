<?php


namespace App\Repositories\Eloquent;

use App\Models\GamePlatform;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;

class GamePlatformRepository implements GamePlatformRepositoryInterface
{

    public function __construct(protected GamePlatform $model) {}


    public function getQuery(): object
    {
        return $this->model->query();
    }
}
