<?php 

namespace App\Services\Game;

use App\Repositories\Contracts\GameCategoryRepositoryInterface;

class GameCategoryService
{
    public function __construct(
        protected GameCategoryRepositoryInterface $gameCategoryRepository
    )
    {
      
    }

    public function all()
    {
        return $this->gameCategoryRepository->all();
    }

    public function paginate()
    {
        return $this->gameCategoryRepository->paginate();
    }
}

