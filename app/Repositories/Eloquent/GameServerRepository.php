<?php 


namespace App\Repositories\Eloquent;

use App\Models\GameServer;
use App\Repositories\Contracts\GameServerRepositoryInterface;

class GameServerRepository implements GameServerRepositoryInterface
{
  
    public function __construct(protected GameServer $model)
    {
      
    }

        public function getQuery(): object
    {
        return $this->model->query();
    }
}