<?php 

namespace App\Repositories\Contracts;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface GameRepositoryInterface
{
    public function getAll():Collection;

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;
    
    public function OnlyTrashedPaginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function deleteGame(array $ids, bool $forceDelete = false): bool;

    public function bulkRestoreGame($ids): bool;

    public function restoreGame($id): bool; 

    public function bulkUpdateStatus($ids, GameStatus $status): bool;

    public function findOrFail($id): Game;

    public function createGame(array $data): Game;

    public function find(int $id): ?Game;

    public function updateGame($id, array $data): bool;
    

}