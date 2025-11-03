<?php 

namespace App\Repositories\Contracts;

use App\Enums\GameCategoryStatus;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GameCategoryRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?GameCategory;

    public function findTrashed($id): ?GameCategory;
    
    public function create(array $data): GameCategory;

    public function update( ?int $id, array $data ): bool;
    
    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function delete($id, int $actionerId): bool ;

    public function forceDelete($id);

   public function restore($id, ?int $actionerId) :bool;

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function bulkDelete(array $ids, int $actionerId): int;

    public function bulkRestore(array $ids, int $actionerId): int;

    public function bulkUpdateStatus(array $ids, ?string $status, int $actionerId): int;

    public function bulkForceDelete(array $ids): int ;

    public function findOrFail($id): GameCategory;

    
}

