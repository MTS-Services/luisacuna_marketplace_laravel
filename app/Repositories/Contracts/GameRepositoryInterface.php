<?php 

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface GameRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;
}