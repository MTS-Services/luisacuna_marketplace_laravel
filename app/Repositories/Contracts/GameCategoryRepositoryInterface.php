<?php 

namespace App\Repositories\Contracts;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GameCategoryRepositoryInterface
{
    public function all(): Collection;
    
    public function create(array $data): GameCategory;

    public function update( $id, array $data): bool;
    
    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function deleteCategory($id, bool $force = false);

   public function restoreDelete($id) :bool;

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function bulkDeleteCategories(array $ids, bool $forceDelete = false): bool;

    public function BulkCategoryRestore(array $ids): bool;

    public function bulkUpdateStatus(array $ids, GameCategoryStatus $status): bool;

    public function findOrFail($id): GameCategory;

    
}

