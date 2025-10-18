<?php 

namespace App\Repositories\Contracts;


use App\Models\GameCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GameCategoryRepositoryInterface
{
    public function all(): Collection;
    
    public function create(array $data): GameCategory;

    public function update( $id, array $data): bool;
    
    public function deleteCategory($id, bool $force = false);
   public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;
}

