<?php 

namespace App\Repositories\Contracts;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Pagination\LengthAwarePaginator;

interface GameRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function bulkDeleteGames($ids, bool $forceDelete = false): bool;

    public function bulkUpdateStatus($ids, GameStatus $status): bool;

    public function findOrFail($id): Game;
}