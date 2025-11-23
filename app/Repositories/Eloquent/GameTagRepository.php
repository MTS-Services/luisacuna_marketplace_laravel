<?php 


namespace App\Repositories\Eloquent;

use App\Models\GameTag;
use App\Repositories\Contracts\GameTagRepositoryInterface;

class GameTagRepository implements GameTagRepositoryInterface
{
  
    public function __construct(protected GameTag $model)
    {
      
    }
        public function getQuery(): object
    {
        return $this->model->query();
    }
}