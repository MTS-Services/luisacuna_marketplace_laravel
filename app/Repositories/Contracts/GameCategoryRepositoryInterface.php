<?php 

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GameCategoryRepositoryInterface
{
    public function all(): Collection;
    
   public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;
}

