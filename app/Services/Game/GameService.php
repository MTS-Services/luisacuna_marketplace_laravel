<?php 

namespace App\Services\Game;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;

class GameService
{
    public function __construct(Protected GameRepositoryInterface $gameRepository)
    { }

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->gameRepository->paginate($perPage, $filters, $queries ?? []);
    }
    
    public function bulkDeleteGames($ids, bool $forceDelete = false)
    {
        return $this->gameRepository->bulkDeleteGames($ids, $forceDelete);
    }

    public function bulkUpdateStatus($ids, GameStatus $status)
    {
        return $this->gameRepository->bulkUpdateStatus($ids, $status);
    }

    public function findOrFail($id): Game
    {
        return $this->gameRepository->findOrFail($id);
    }
}