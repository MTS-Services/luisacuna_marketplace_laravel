<?php 


namespace App\Repositories\Eloquent;

use App\Models\GameType;
use App\Repositories\Contracts\GameTypeRepositoryInterface;

class GameTypeRepository implements GameTypeRepositoryInterface
{
  
    public function __construct(protected GameType $model)
    {
      
    }
        public function getQuery(): object
    {
        return $this->model->query();
    }
}