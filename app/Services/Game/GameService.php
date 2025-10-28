<?php 

namespace App\Services\Game;

use App\Actions\Game\CreateGameAction;
use App\Actions\Game\DeleteGameAction;
use App\Actions\Game\UpdateGameAction;
use App\DTOs\Game\CreateGameDTO;
use App\DTOs\Game\UpdateGameDTO;
use App\Enums\GameStatus;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;

class GameService
{
    public function __construct(
         protected GameRepositoryInterface $gameRepository,
         protected CreateGameAction $createGameAction , 
         protected DeleteGameAction $deleteGameAction,
         protected UpdateGameAction $updateGameAction
         )
    { }

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->gameRepository->paginate($perPage, $filters, $queries ?? []);
    }
    
    public function OnlyTrashedPaginate(int $perPage = 15, array $filters = [], ?array $queries = null) 
    {
        return $this->gameRepository->OnlyTrashedPaginate($perPage, $filters, $queries ?? []);
    }

    public function deleteGame(array $ids, bool $forceDelete = false)
    {
        return $this->deleteGameAction->execute($ids, $forceDelete);
    }

    public function bulkUpdateStatus($ids, GameStatus $status)
    {
        return $this->gameRepository->bulkUpdateStatus($ids, $status);
    }

    public function bulkRestoreGame($ids) :bool
    {
        return $this->gameRepository->bulkRestoreGame($ids);
    }

    public function restoreGame($id) :bool
    {
        return $this->gameRepository->restoreGame($id);
    }
    public function findOrFail($id): Game
    {
        return $this->gameRepository->findOrFail($id);
    }

    public function createGame(CreateGameDTO $data): Game
    {
        return $this->createGameAction->execute($data);
    }

    public function updateGame($id, UpdateGameDTO $dto): bool
    {
        return $this->updateGameAction->execute($id, $dto);
    }
}