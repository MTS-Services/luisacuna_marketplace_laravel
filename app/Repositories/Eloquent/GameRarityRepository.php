<?php 


namespace App\Repositories\Eloquent;

use App\Models\GameRarity;
use App\Repositories\Contracts\GameRarityRepositoryInterface;

class GameRarityRepository implements GameRarityRepositoryInterface
{
  
    public function __construct(protected GameRarity $model)
    {
      
    }

    public function getQuery(): object
    {
        return $this->model->query();
    }
}