<?php 

namespace App\Services\Game;

use App\Repositories\Contracts\GameRepositoryInterface;

class GameService
{
    public function __construct(Protected GameRepositoryInterface $gameRepository)
    { }

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->gameRepository->paginate($perPage, $filters, $queries ?? []);
    }
    
}